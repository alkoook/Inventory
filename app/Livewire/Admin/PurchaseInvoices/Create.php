<?php

namespace App\Livewire\Admin\PurchaseInvoices;

use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Company;
use App\Models\Product;
use App\Models\InventoryTransaction;
use Livewire\Component;

class Create extends Component
{
    public $company_id = '';
    public $invoice_date;
    public $notes = '';
    public $items = [];

    protected $rules = [
        'company_id' => 'required|exists:companies,id',
        'invoice_date' => 'required|date',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->invoice_date = now()->format('Y-m-d');
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'quantity' => 1, 'unit_price' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        if (str_contains($key, 'product_id')) {
            $index = explode('.', $key)[0];
            $product = Product::find($this->items[$index]['product_id']);
            if ($product) {
                $this->items[$index]['unit_price'] = $product->purchase_price;
            }
        }
    }

    public function save()
    {
        $this->validate();

        $totalAmount = collect($this->items)->sum(function($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $invoice = PurchaseInvoice::create([
            'company_id' => $this->company_id,
            'invoice_number' => 'PINV-' . time(),
            'invoice_date' => $this->invoice_date,
            'total_amount' => $totalAmount,
            'notes' => $this->notes,
        ]);

        foreach ($this->items as $item) {
            PurchaseInvoiceItem::create([
                'purchase_invoice_id' => $invoice->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
            ]);

            InventoryTransaction::createTransaction(
                $item['product_id'],
                'purchase',
                $item['quantity'],
                'App\Models\PurchaseInvoice',
                $invoice->id,
                'شراء - فاتورة: ' . $invoice->invoice_number
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
