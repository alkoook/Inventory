<?php

namespace App\Livewire\Admin\PurchaseInvoices;

use App\Models\Company;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use Livewire\Component;

class Create extends Component
{
    public $company_id = '';

    public $invoice_date;

    public $currency = 'USD';

    public $notes = '';

    public $items = [];

    public $total_amount = 0.00;

    public $products = [];

    protected $rules = [
        'company_id' => 'nullable|exists:companies,id',
        'invoice_date' => 'required|date',
        'currency' => 'required|in:USD,SYP',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_of_measure' => 'required|in:غرام,كيلو,قطعة,علبة,كيس,ظرف,تنكة,طرد',
        'items.*.unit_price' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->invoice_date = now()->format('Y-m-d');
        $this->products = Product::select('id', 'name', 'sku', 'purchase_price', 'sale_price')->get();
        $this->addItem();
        $this->calculateTotal();
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => null,
            'product_search' => '',
            'quantity' => 1,
            'unit_of_measure' => 'قطعة',
            'unit_price' => 0.00,
            'old_sale_price' => 0.00, // For display only
        ];
        $this->calculateTotal();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function updated($property, $value)
    {
        // تحديث Total Amount عند تغيير الكمية أو السعر
        if (preg_match('/items\.(\d+)\.(quantity|unit_price)/', $property)) {
            $this->calculateTotal();
        }

        // مزامنة بيانات المنتج عند البحث
        if (preg_match('/items\.(\d+)\.product_search/', $property, $matches)) {
            $index = $matches[1];
            $search_term = $this->items[$index]['product_search'] ?? '';

            // محاولة استخراج ID من القيمة (إذا كانت تحتوي على اسم المنتج و SKU)
            $product_data = explode('—', $search_term);
            $product_name = trim($product_data[0]);

            $product = $this->products->first(function ($p) use ($product_name) {
                return $p->name === $product_name;
            });

            if ($product) {
                $this->items[$index]['product_id'] = $product->id;
                // تحديث سعر الوحدة تلقائياً من سعر الشراء للمنتج
                $this->items[$index]['unit_price'] = $product->purchase_price;
                // حفظ سعر البيع القديم للعرض فقط
                $this->items[$index]['old_sale_price'] = $product->sale_price ?? 0;
                $this->calculateTotal();
            } else {
                $this->items[$index]['product_id'] = null;
                $this->items[$index]['old_sale_price'] = 0;
            }
        }
    }
    
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $quantity = (float) ($item['quantity'] ?? 0);
            $price = (float) ($item['unit_price'] ?? 0);
            $total += $quantity * $price;
        }
        $this->total_amount = round($total, 2);
    }

    public function save()
    {
        $this->validate();

        $totalAmount = collect($this->items)->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $invoice = PurchaseInvoice::create([
            'company_id' => $this->company_id ?: null,
            'invoice_number' => 'PINV-'.time(),
            'invoice_date' => $this->invoice_date,
            'total_amount' => $totalAmount,
            'currency' => $this->currency,
            'notes' => $this->notes,
        ]);

        foreach ($this->items as $item) {
            PurchaseInvoiceItem::create([
                'purchase_invoice_id' => $invoice->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_of_measure' => $item['unit_of_measure'] ?? 'قطعة',
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
            ]);

            InventoryTransaction::createTransaction(
                $item['product_id'],
                'purchase',
                $item['quantity'],
                'App\Models\PurchaseInvoice',
                $invoice->id,
                'شراء - فاتورة: '.$invoice->invoice_number
            );
        }

        session()->flash('message', 'تم إنشاء الفاتورة بنجاح.');

        return redirect()->route('admin.purchase-invoices.index');
    }

    public function render()
    {
        $companies = Company::where('is_active', true)->get();
        $products = Product::all();

        return view('livewire.admin.purchase-invoices.create', [
            'companies' => $companies,
            'products' => $products,
        ])->layout('components.layouts.admin', ['header' => 'إنشاء فاتورة مشتريات']);
    }
}
