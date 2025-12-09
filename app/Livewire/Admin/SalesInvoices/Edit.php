<?php

namespace App\Livewire\Admin\SalesInvoices;

use App\Models\Product;
use App\Models\SalesInvoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $invoice_id;

    public $user_id;

    public $customer_name;

    public $invoice_date;

    public $currency = 'USD';

    public $notes;

    public $items = [];

    public $customers = [];

    public $products = [];

    public $total_amount = 0.00;

    public $cost_amount = 0.00;

    public $profit_amount = 0.00;

    public function mount($id)
    {
        $this->invoice_id = $id;
        $invoice = SalesInvoice::with('items.product')->findOrFail($id);

        $this->user_id = $invoice->user_id;
        $this->customer_name = $invoice->user->name ?? '';
        $this->invoice_date = $invoice->invoice_date->format('Y-m-d');
        $this->currency = $invoice->currency ?? 'USD';
        $this->notes = $invoice->notes;

        $this->customers = User::select('id', 'name')->get();
        $this->products = Product::select('id', 'name', 'sku', 'sale_price', 'purchase_price', 'unit_of_measure', 'stock')->get();

        // تحميل الأصناف
        foreach ($invoice->items as $item) {
            $this->items[] = [
                'product_id' => $item->product_id,
                'product_search' => $item->product->name.' — '.$item->product->sku,
                'quantity' => $item->quantity,
                'unit_of_measure' => $item->unit_of_measure,
                'unit_price' => $item->unit_price,
                'cost_price' => $item->product->purchase_price ?? 0,
            ];
        }

        $this->calculateTotal();
    }

    protected function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'invoice_date' => 'required|date',
            'currency' => 'required|in:USD,SYP',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_of_measure' => 'required|in:غرام,كيلو,قطعة,علبة,كيس,ظرف,تنكة,طرد',
            'items.*.unit_price' => 'required|numeric|min:0',
        ];
    }

    public function updated($property, $value)
    {
        if ($property === 'customer_name') {
            $customer = $this->customers->firstWhere('name', $value);
            $this->user_id = $customer ? $customer->id : null;
        }

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

        if (preg_match('/items\.(\d+)\.product_search/', $property, $matches)) {
            $index = $matches[1];
            $search_term = $this->items[$index]['product_search'];

            $product_data = explode('—', $search_term);
            $product_name = trim($product_data[0]);

            $product = $this->products->first(function ($p) use ($product_name) {
                return $p->name === $product_name;
            });

            if ($product) {
                $this->items[$index]['product_id'] = $product->id;
                $this->items[$index]['unit_price'] = $product->sale_price;
                $this->items[$index]['cost_price'] = $product->purchase_price ?? 0;
                // تعيين وحدة القياس من المنتج
                $this->items[$index]['unit_of_measure'] = $product->unit_of_measure ?? 'قطعة';
                $this->calculateTotal();
            } else {
                $this->items[$index]['product_id'] = null;
                $this->items[$index]['cost_price'] = 0;
            }
        }
    }

    public function calculateTotal()
    {
        $total = 0;
        $cost = 0;
        foreach ($this->items as $item) {
            $quantity = (float) ($item['quantity'] ?? 0);
            $price = (float) ($item['unit_price'] ?? 0);
            $item_cost = (float) ($item['cost_price'] ?? 0);

            $total += $quantity * $price;
            $cost += $quantity * $item_cost;
        }

        $this->total_amount = round($total, 2);
        $this->cost_amount = round($cost, 2);
        $this->profit_amount = round($this->total_amount - $this->cost_amount, 2);
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => null,
            'product_search' => '',
            'quantity' => 1,
            'unit_of_measure' => 'قطعة',
            'unit_price' => 0.00,
            'cost_price' => 0.00,
        ];
        $this->calculateTotal();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function save()
    {
        $this->calculateTotal();
        $this->validate();

        // التحقق من المخزون قبل تحديث الفاتورة
        $invoice = SalesInvoice::with('items')->findOrFail($this->invoice_id);
        
        // حساب الكميات القديمة والجديدة
        $oldItems = [];
        foreach ($invoice->items as $oldItem) {
            $oldItems[$oldItem->product_id] = ($oldItems[$oldItem->product_id] ?? 0) + $oldItem->quantity;
        }

        foreach ($this->items as $itemData) {
            $product = Product::find($itemData['product_id']);
            if (!$product) {
                session()->flash('error', "المنتج غير موجود");
                return;
            }

            $oldQuantity = $oldItems[$itemData['product_id']] ?? 0;
            $newQuantity = $itemData['quantity'];
            $quantityDifference = $newQuantity - $oldQuantity;

            // إذا زادت الكمية، يجب التحقق من المخزون
            if ($quantityDifference > 0) {
                if ($product->stock < $quantityDifference) {
                    session()->flash('error', "المخزون غير كافٍ للمنتج '{$product->name}'. المخزون المتاح: {$product->stock}، المطلوب إضافته: {$quantityDifference}");
                    return;
                }
            }
        }

        try {
            DB::transaction(function () use ($invoice) {

                $invoice->update([
                    'user_id' => $this->user_id,
                    'invoice_date' => $this->invoice_date,
                    'total_amount' => $this->total_amount,
                    'cost_amount' => $this->cost_amount,
                    'profit_amount' => $this->profit_amount,
                    'currency' => $this->currency,
                    'notes' => $this->notes,
                ]);

                // حفظ الكميات القديمة قبل الحذف
                $oldItems = [];
                foreach ($invoice->items as $oldItem) {
                    $oldItems[$oldItem->product_id] = ($oldItems[$oldItem->product_id] ?? 0) + $oldItem->quantity;
                }

                // حذف الأصناف القديمة
                $invoice->items()->delete();

                // إضافة الأصناف الجديدة وإنشاء/تحديث معاملات المخزون
                foreach ($this->items as $itemData) {
                    $invoice->items()->create([
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'unit_of_measure' => $itemData['unit_of_measure'] ?? 'قطعة',
                        'unit_price' => $itemData['unit_price'],
                        'total_price' => $itemData['quantity'] * $itemData['unit_price'],
                    ]);

                    $oldQuantity = $oldItems[$itemData['product_id']] ?? 0;
                    $newQuantity = $itemData['quantity'];
                    $quantityDifference = $newQuantity - $oldQuantity;

                    if ($quantityDifference > 0) {
                        // زيادة الكمية - بيع إضافي
                        \App\Models\InventoryTransaction::createTransaction(
                            $itemData['product_id'],
                            'sale',
                            $quantityDifference,
                            'App\Models\SalesInvoice',
                            $invoice->id,
                            'تعديل فاتورة - بيع إضافي: '.$invoice->invoice_number
                        );
                    } elseif ($quantityDifference < 0) {
                        // تقليل الكمية - إرجاع
                        \App\Models\InventoryTransaction::createTransaction(
                            $itemData['product_id'],
                            'return_sale',
                            abs($quantityDifference),
                            'App\Models\SalesInvoice',
                            $invoice->id,
                            'تعديل فاتورة - إرجاع: '.$invoice->invoice_number
                        );
                    }
                }

                session()->flash('message', 'تم تحديث فاتورة المبيعات بنجاح!');
                $this->redirect(route('admin.sales-invoices.index'), navigate: true);
            });
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء تحديث الفاتورة: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.sales-invoices.edit', [
            'customers' => $this->customers,
            'products' => $this->products,
        ])->layout('components.layouts.admin', ['header' => 'تعديل فاتورة مبيعات']);
    }
}

