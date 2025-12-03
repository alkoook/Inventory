<?php

namespace App\Livewire\Admin;

use App\Models\Company;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseInvoices extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEdit = false;

    // Form Fields
    public $invoice_id;
    public $company_id;
    public $invoice_number;
    public $invoice_date;
    public $notes;
    public $items = [];
    public $paid_amount = 0;

    // Computed
    public $total_amount = 0;
    public $remaining_amount = 0;

    protected $rules = [
        'company_id' => 'required|exists:companies,id',
        'invoice_number' => 'required|string|unique:purchase_invoices,invoice_number',
        'invoice_date' => 'required|date',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'paid_amount' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->invoice_date = now()->format('Y-m-d');
        $this->addItem();
    }

    public function render()
    {
        $invoices = PurchaseInvoice::with(['company', 'items'])
            ->where('invoice_number', 'like', '%' . $this->search . '%')
            ->orWhereHas('company', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        $companies = Company::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();

        return view('livewire.admin.purchase-invoices', [
            'invoices' => $invoices,
            'companies' => $companies,
            'products' => $products,
        ])->layout('components.layouts.admin', ['header' => 'فواتير الشراء']);
    }

    public function create()
    {
        $this->reset(['invoice_id', 'company_id', 'notes', 'items', 'paid_amount', 'total_amount', 'remaining_amount']);
        $this->invoice_number = 'INV-' . strtoupper(Str::random(8));
        $this->invoice_date = now()->format('Y-m-d');
        $this->items = [];
        $this->addItem();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $invoice = PurchaseInvoice::with('items')->findOrFail($id);
        $this->invoice_id = $id;
        $this->company_id = $invoice->company_id;
        $this->invoice_number = $invoice->invoice_number;
        $this->invoice_date = $invoice->invoice_date->format('Y-m-d');
        $this->notes = $invoice->notes;
        $this->paid_amount = $invoice->paid_amount;

        $this->items = [];
        foreach ($invoice->items as $item) {
            $this->items[] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
            ];
        }

        $this->calculateTotals();
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'total_price' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotals();
    }

    public function updatedItems($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) < 2) return;

        $index = $parts[0];
        $field = $parts[1];

        if ($field === 'product_id') {
            $product = Product::find($value);
            if ($product) {
                $this->items[$index]['unit_price'] = $product->purchase_price;
            }
        }

        // Recalculate line total
        if (isset($this->items[$index]['quantity']) && isset($this->items[$index]['unit_price'])) {
            $this->items[$index]['total_price'] = (float)$this->items[$index]['quantity'] * (float)$this->items[$index]['unit_price'];
        }

        $this->calculateTotals();
    }

    public function updatedPaidAmount()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->total_amount = 0;
        foreach ($this->items as $item) {
            $this->total_amount += (float)($item['total_price'] ?? 0);
        }
        $this->remaining_amount = $this->total_amount - (float)$this->paid_amount;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->isEdit) {
            $rules['invoice_number'] = 'required|string|unique:purchase_invoices,invoice_number,' . $this->invoice_id;
        }

        $this->validate($rules);

        $data = [
            'company_id' => $this->company_id,
            'invoice_number' => $this->invoice_number,
            'invoice_date' => $this->invoice_date,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'remaining_amount' => $this->remaining_amount,
            'notes' => $this->notes,
            'status' => 'approved',
        ];

        if ($this->isEdit) {
            $invoice = PurchaseInvoice::find($this->invoice_id);
            $invoice->update($data);
            $invoice->items()->delete();
        } else {
            $invoice = PurchaseInvoice::create($data);
        }

        foreach ($this->items as $item) {
            $invoice->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
            ]);

            if (!$this->isEdit) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                    $product->update(['purchase_price' => $item['unit_price']]);
                }
            }
        }

        session()->flash('message', $this->isEdit ? 'تم تحديث الفاتورة بنجاح.' : 'تم إنشاء الفاتورة وتحديث المخزون بنجاح.');
        $this->showModal = false;
        $this->reset(['invoice_id', 'company_id', 'notes', 'items', 'paid_amount', 'total_amount', 'remaining_amount']);
    }

    public function delete($id)
    {
        $invoice = PurchaseInvoice::with('items')->find($id);
        if ($invoice) {
            foreach ($invoice->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }
            $invoice->delete();
            session()->flash('message', 'تم حذف الفاتورة واسترجاع المخزون.');
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
