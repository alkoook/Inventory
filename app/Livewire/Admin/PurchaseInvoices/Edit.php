<?php

namespace App\Livewire\Admin\PurchaseInvoices;

use App\Models\Company;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use Livewire\Component;

class Edit extends Component
{
    public $invoice_id;

    public $company_id = null;

    public $invoice_date;

    public $currency = 'USD';

    public $notes = '';

    public $items = [];

    public $total_amount = 0.00;

    public $products = [];

    public function mount($id)
    {
        $this->invoice_id = $id;
        $invoice = PurchaseInvoice::with('items.product')->findOrFail($id);

        $this->company_id = $invoice->company_id;
        $this->invoice_date = $invoice->invoice_date->format('Y-m-d');
        $this->currency = $invoice->currency ?? 'USD';
        $this->notes = $invoice->notes;

        $this->products = Product::select('id', 'name', 'sku', 'purchase_price')->get();

        // تحميل الأصناف
        foreach ($invoice->items as $item) {
            $this->items[] = [
                'product_id' => $item->product_id,
                'product_search' => $item->product->name.' — '.$item->product->sku,
                'quantity' => $item->quantity,
                'unit_of_measure' => $item->unit_of_measure,
                'unit_price' => $item->unit_price,
            ];
        }

        $this->calculateTotal();
    }

    protected function rules()
    {
        return [
            'company_id' => 'nullable|exists:companies,id',
            'invoice_date' => 'required|date',
            'currency' => 'required|in:USD,SYP',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_of_measure' => 'required|in:غرام,كيلو,قطعة,علبة,كيس,ظرف,تنكة,طرد',
            'items.*.unit_price' => 'required|numeric|min:0',
        ];
    }

    public function updated($property, $value)
    {
        if (preg_match('/items\.(\d+)\.(quantity|unit_price)/', $property)) {
            $this->calculateTotal();
        }

        if (preg_match('/items\.(\d+)\.product_search/', $property, $matches)) {
            $index = $matches[1];
            $search_term = $this->items[$index]['product_search'] ?? '';

            $product_data = explode('—', $search_term);
            $product_name = trim($product_data[0]);

            $product = $this->products->first(function ($p) use ($product_name) {
                return $p->name === $product_name;
            });

            if ($product) {
                $this->items[$index]['product_id'] = $product->id;
                $this->items[$index]['unit_price'] = $product->purchase_price;
                $this->calculateTotal();
            } else {
                $this->items[$index]['product_id'] = null;
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

    public function addItem()
    {
        $this->items[] = [
            'product_id' => null,
            'product_search' => '',
            'quantity' => 1,
            'unit_of_measure' => 'قطعة',
            'unit_price' => 0.00,
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
        $this->validate();
        $this->calculateTotal();

        $invoice = PurchaseInvoice::findOrFail($this->invoice_id);

        $invoice->update([
            'company_id' => $this->company_id ?: null,
            'invoice_date' => $this->invoice_date,
            'total_amount' => $this->total_amount,
            'currency' => $this->currency,
            'notes' => $this->notes,
        ]);

        // حذف الأصناف القديمة
        $invoice->items()->delete();

        // إضافة الأصناف الجديدة
        foreach ($this->items as $item) {
            PurchaseInvoiceItem::create([
                'purchase_invoice_id' => $invoice->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_of_measure' => $item['unit_of_measure'] ?? 'قطعة',
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        session()->flash('message', 'تم تحديث الفاتورة بنجاح.');

        return redirect()->route('admin.purchase-invoices.index');
    }

    public function render()
    {
        $companies = Company::where('is_active', true)->get();

        return view('livewire.admin.purchase-invoices.edit', [
            'companies' => $companies,
            'products' => $this->products,
        ])->layout('components.layouts.admin', ['header' => 'تعديل فاتورة مشتريات']);
    }
}

