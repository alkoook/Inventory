<?php

namespace App\Livewire\Admin\SalesInvoices;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Invoice; // نفترض وجود نموذج الفاتورة
use App\Models\SalesInvoice;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // تم إضافة هذا

class Create extends Component
{
    // === 1. خصائص بيانات الفاتورة الأساسية ===
    public $user_id;
    public $customer_name; // يُستخدم للبحث عبر datalist
    public $invoice_date;
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
        
        // جلب قائمة العملاء والمنتجات الأولية (للعرض في datalist)
        // يجب أن يحتوي Product على سعر التكلفة (cost_price)
        $this->customers = User::select('id', 'name')->get();
        $this->products = Product::select('id', 'name', 'sku', 'sale_price', 'purchase_price')->get(); // تم إضافة cost_price

        // إضافة صنف افتراضي واحد عند التحميل
        $this->addItem();
    }

    protected function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'invoice_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
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
            $this->user_id = $customer ? $customer->id : null;
        }

        // 2. تحديث Total Amount و Cost Amount عند تغيير الكمية أو السعر
        if (preg_match('/items\.(\d+)\.(quantity|unit_price)/', $property)) {
            $this->calculateTotal();
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
                // تحديث سعر التكلفة للحسابات
                $this->items[$index]['cost_price'] = $product->cost_price ?? 0; // إضافة cost_price
                $this->calculateTotal();
            } else {
                $this->items[$index]['product_id'] = null;
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
            $quantity = (float)($item['quantity'] ?? 0);
            $price = (float)($item['unit_price'] ?? 0);
            $item_cost = (float)($item['cost_price'] ?? 0); // جلب سعر التكلفة
            
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
            'unit_price' => 0.00,
            'purchase_price' => 0.00, // تمت إضافة الحقل
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

        try {
            DB::transaction(function () {
                // 1. إنشاء الفاتورة الرئيسية
                $invoice = SalesInvoice::create([
                    'user_id' => $this->user_id,
                    'invoice_date' => $this->invoice_date,
                    'invoice_number' =>"INV_".now()->format('YmdHis'), 
                    'total_amount' => $this->total_amount, 
                    'cost_amount' => $this->cost_amount, // تم إضافة حقل تكلفة البضاعة
                    'profit_amount' => $this->profit_amount, // تم إضافة حقل الربح
                    'status' => 'approved', // تعيين القيمة الافتراضية 'approved'
                    'notes' => $this->notes,
                ]);

                // 2. حفظ أصناف الفاتورة
                // foreach ($this->items as $itemData) {
                //     $invoice->items()->create([ // نفترض وجود علاقة items() في نموذج Invoice
                //         'sales_invoice_id'=>$invoice->id,
                //         'product_id' => $itemData['product_id'],
                //         'quantity' => $itemData['quantity'],
                //         'unit_price' => $itemData['unit_price'], // حفظ سعر التكلفة على مستوى الصنف
                //     ]);
                // }
          

            session()->flash('message', 'تم إنشاء فاتورة المبيعات بنجاح!');
            
            // إعادة توجيه المستخدم أو إعادة تعيين النموذج
            $this->redirect(route('admin.sales-invoices.index'), navigate: true);
  });
        } catch (\Exception $e) {
  dd($e);

            session()->flash('error', 'حدث خطأ أثناء حفظ الفاتورة: ' . $e->getMessage());
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