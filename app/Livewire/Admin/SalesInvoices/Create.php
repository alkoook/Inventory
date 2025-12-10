<?php

namespace App\Livewire\Admin\SalesInvoices;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product; // نفترض وجود نموذج الفاتورة
use App\Models\SalesInvoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

// تم إضافة هذا

class Create extends Component
{
    // === 1. خصائص بيانات الفاتورة الأساسية ===
    public $customer_user_id; // الزبون الذي اشترى

    public $customer_name; // يُستخدم للبحث عبر datalist

    public $invoice_date;

    public $currency = 'USD';

    public $notes;

    // === 2. مصفوفة الأصناف (Invoice Items) ===
    // تمت إضافة 'cost_price' هنا ليتم استخدامه في الحسابات
    // تحتوي على: product_id, product_search, quantity, unit_price, cost_price
    public $items = [];

    // === 3. بيانات العرض (Lookups) ===
    public $customers = [];

    public $products = [];

    public $search_customer_term = ''; // لا يستخدم هنا، لكن يتم استخدامه ضمن دالة البحث

    // === 4. خصائص الحالة ===
    public $total_amount = 0.00;

    public $cost_amount = 0.00; // خصائص جديدة

    public $profit_amount = 0.00; // خصائص جديدة

    public function mount()
    {
        // تهيئة التاريخ الافتراضي
        $this->invoice_date = Carbon::today()->toDateString();

        // جلب قائمة العملاء (customers فقط) والمنتجات الأولية (للعرض في datalist)
        // يجب أن يحتوي Product على سعر التكلفة (cost_price)
        $this->customers = User::role('customer')->select('id', 'name')->get();
        $this->products = Product::select('id', 'name', 'sku', 'sale_price', 'purchase_price')->get(); // تم إضافة cost_price

        // إضافة صنف افتراضي واحد عند التحميل
        $this->addItem();
    }

    protected function rules()
    {
        return [
            'customer_user_id' => 'required|exists:users,id',
            'invoice_date' => 'required|date',
            'currency' => 'required|in:USD',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_of_measure' => 'required|in:غرام,كيلو,قطعة,علبة,كيس,ظرف,تنكة,طرد',
            'items.*.unit_price' => 'required|numeric|min:0',
        ];
    }

    /**
     * تحديث المنطق عند تغيير أي حقل.
     * يستخدم لمزامنة customer_id عند اختيار العميل من datalist.
     */
    public function updated($property, $value)
    {
        // 1. تحديد Customer ID من Customer Name
        if ($property === 'customer_name') {
            $customer = $this->customers->firstWhere('name', $value);
            $this->customer_user_id = $customer ? $customer->id : null;
        }

        // 2. تحديث Total Amount و Cost Amount عند تغيير الكمية أو السعر
        if (preg_match('/items\.(\d+)\.(quantity|unit_price)/', $property)) {
            $this->calculateTotal();
            
            // التحقق من المخزون عند تغيير الكمية
            if (preg_match('/items\.(\d+)\.quantity/', $property, $matches)) {
                $index = $matches[1];
                $productId = $this->items[$index]['product_id'] ?? null;
                $quantity = $this->items[$index]['quantity'] ?? 0;
                
                if ($productId && $quantity > 0) {
                    $product = $this->products->firstWhere('id', $productId);
                    if ($product && $quantity > $product->stock) {
                        $this->addError("items.$index.quantity", "المخزون المتاح: {$product->stock}");
                        // تقليل الكمية تلقائياً إلى المخزون المتاح
                        $this->items[$index]['quantity'] = $product->stock;
                    }
                }
            }
        }

        // 3. مزامنة بيانات المنتج عند البحث
        if (preg_match('/items\.(\d+)\.product_search/', $property, $matches)) {
            $index = $matches[1];
            $search_term = $this->items[$index]['product_search'];

            // محاولة استخراج ID من القيمة (إذا كانت تحتوي على اسم المنتج و SKU)
            $product_data = explode('—', $search_term);
            $product_name = trim($product_data[0]);

            $product = $this->products->first(function ($p) use ($product_name) {
                return $p->name === $product_name;
            });

            if ($product) {
                $this->items[$index]['product_id'] = $product->id;
                // تحديث سعر الوحدة تلقائياً من سعر البيع للمنتج
                $this->items[$index]['unit_price'] = $product->sale_price;
                // تحديث سعر الشراء للعرض فقط (لا يتم حفظه)
                $this->items[$index]['purchase_price'] = $product->purchase_price ?? 0;
                // تحديث سعر التكلفة للحسابات
                $this->items[$index]['cost_price'] = $product->purchase_price ?? 0;
                // تعيين وحدة القياس من المنتج
                $this->items[$index]['unit_of_measure'] = $product->unit_of_measure ?? 'قطعة';
                $this->calculateTotal();
            } else {
                $this->items[$index]['product_id'] = null;
                $this->items[$index]['purchase_price'] = 0;
                $this->items[$index]['cost_price'] = 0;
            }
        }
    }

    /**
     * حساب إجمالي الفاتورة وتكلفة البضاعة المباعة والربح
     */
    public function calculateTotal()
    {
        $total = 0;
        $cost = 0;
        foreach ($this->items as $item) {
            $quantity = (float) ($item['quantity'] ?? 0);
            $price = (float) ($item['unit_price'] ?? 0);
            $item_cost = (float) ($item['cost_price'] ?? 0); // جلب سعر التكلفة

            $total += $quantity * $price;
            $cost += $quantity * $item_cost;
        }

        $this->total_amount = round($total, 2);
        $this->cost_amount = round($cost, 2); // حفظ إجمالي التكلفة
        $this->profit_amount = round($this->total_amount - $this->cost_amount, 2); // حساب الربح
    }

    /**
     * إضافة صنف جديد فارغ إلى مصفوفة $items
     */
    public function addItem()
    {
        $this->items[] = [
            'product_id' => null,
            'product_search' => '',
            'quantity' => 1,
            'unit_of_measure' => 'قطعة',
            'unit_price' => 0.00,
            'purchase_price' => 0.00, // For display only
        ];
        $this->calculateTotal();
    }

    /**
     * حذف صنف من مصفوفة $items بناءً على الـ index
     */
    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // إعادة ترتيب المفاتيح بعد الحذف
        $this->calculateTotal();
    }

    /**
     * حفظ الفاتورة وأصنافها
     */
    public function save()
    {
        // التأكد من أن الإجمالي محدّث قبل التحقق
        $this->calculateTotal();

        $this->validate();

        // التحقق من المخزون قبل حفظ الفاتورة
        foreach ($this->items as $itemData) {
            $product = Product::find($itemData['product_id']);
            if (!$product) {
                session()->flash('error', "المنتج غير موجود");
                return;
            }
            
            if ($product->stock < $itemData['quantity']) {
                session()->flash('error', "المخزون غير كافٍ للمنتج '{$product->name}'. المخزون المتاح: {$product->stock}، المطلوب: {$itemData['quantity']}");
                return;
            }
        }

        try {
            DB::transaction(function () {
                // 1. إنشاء الفاتورة الرئيسية
                $invoice = SalesInvoice::create([
                    'user_id' => auth()->id(), // المستخدم الذي ينشئ الفاتورة (admin/manager)
                    'customer_user_id' => $this->customer_user_id, // الزبون الذي اشترى
                    'invoice_date' => $this->invoice_date,
                    'invoice_number' => 'INV_'.now()->format('YmdHis'),
                    'total_amount' => $this->total_amount,
                    'cost_amount' => $this->cost_amount, // تم إضافة حقل تكلفة البضاعة
                    'profit_amount' => $this->profit_amount, // تم إضافة حقل الربح
                    'status' => 'approved', // تعيين القيمة الافتراضية 'approved'
                    'currency' => $this->currency,
                    'notes' => $this->notes,
                ]);

                // 2. حفظ أصناف الفاتورة وإنشاء معاملات المخزون
                foreach ($this->items as $itemData) {
                    $invoice->items()->create([
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'unit_of_measure' => $itemData['unit_of_measure'] ?? 'قطعة',
                        'unit_price' => $itemData['unit_price'],
                        'total_price' => $itemData['quantity'] * $itemData['unit_price'],
                    ]);

                    // إنشاء معاملة المخزون (بيع)
                    \App\Models\InventoryTransaction::createTransaction(
                        $itemData['product_id'],
                        'sale',
                        $itemData['quantity'],
                        'App\Models\SalesInvoice',
                        $invoice->id,
                        'بيع - فاتورة: '.$invoice->invoice_number
                    );
                }

                session()->flash('message', 'تم إنشاء فاتورة المبيعات بنجاح!');

                // إعادة توجيه المستخدم أو إعادة تعيين النموذج
                $this->redirect(route('admin.sales-invoices.index'), navigate: true);
            });
        } catch (\Exception $e) {
            dd($e);

            session()->flash('error', 'حدث خطأ أثناء حفظ الفاتورة: '.$e->getMessage());
            // يمكنك استخدام log::error هنا
        }
    }

    public function render()
    {
        // تمرير البيانات اللازمة للـ View
        return view('livewire.admin.sales-invoices.create', [
            'customers' => $this->customers,
            'products' => $this->products, // المنتجات تحتاج إلى تمرير لـ datalist
        ])->layout('components.layouts.admin', ['header' => 'إنشاء فاتورة مبيعات']);
    }
}
