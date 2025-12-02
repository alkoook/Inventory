<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SalesInvoices extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEdit = false;

    // Form Fields
    public $invoice_id;
    public $customer_id;
    public $invoice_number;
    public $invoice_date;
    public $items = [];
    
    // Computed
    public $total_amount = 0;

    protected $rules = [
        'customer_id' => 'required|exists:customers,id',
        'invoice_number' => 'required|string|unique:sales_invoices,invoice_number',
        'invoice_date' => 'required|date',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->invoice_date = now()->format('Y-m-d');
    }

    public function render()
    {
        $invoices = SalesInvoice::with(['customer', 'items'])
            ->where('invoice_number', 'like', '%' . $this->search . '%')
            ->orWhereHas('customer', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        $customers = Customer::where('is_active', true)->get();
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();

        return view('livewire.admin.sales-invoices', [
            'invoices' => $invoices,
            'customers' => $customers,
            'products' => $products,
        ])->layout('components.layouts.admin', ['header' => 'فواتير المبيعات']);
    }

    public function create()
    {
        $this->reset(['invoice_id', 'customer_id', 'items', 'total_amount']);
        $this->invoice_number = 'INV-' . strtoupper(Str::random(8));
        $this->invoice_date = now()->format('Y-m-d');
        $this->items = [];
        $this->addItem();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $invoice = SalesInvoice::with('items')->findOrFail($id);
        $this->invoice_id = $id;
        $this->customer_id = $invoice->customer_id;
        $this->invoice_number = $invoice->invoice_number;
        $this->invoice_date = $invoice->invoice_date->format('Y-m-d');
        
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

        if ($field === 'product_id' && !empty($value)) {
            $product = Product::find($value);
            if ($product) {
                $this->items[$index]['unit_price'] = $product->sale_price;
            }
        }

        if (isset($this->items[$index]['quantity']) && isset($this->items[$index]['unit_price'])) {
            $this->items[$index]['total_price'] = (float)$this->items[$index]['quantity'] * (float)$this->items[$index]['unit_price'];
        }

        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->total_amount = 0;
        foreach ($this->items as $item) {
            $this->total_amount += (float)($item['total_price'] ?? 0);
        }
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->isEdit) {
            $rules['invoice_number'] = 'required|string|unique:sales_invoices,invoice_number,' . $this->invoice_id;
        }
        
        $this->validate($rules);

        // Check stock availability
        foreach ($this->items as $item) {
            $product = Product::find($item['product_id']);
            
            // If editing, we need to consider the quantity already in the invoice
            $currentQtyInInvoice = 0;
            if ($this->isEdit) {
                $oldItem = SalesInvoiceItem::where('sales_invoice_id', $this->invoice_id)
                    ->where('product_id', $item['product_id'])
                    ->first();
                if ($oldItem) {
                    $currentQtyInInvoice = $oldItem->quantity;
                }
            }

            // Available stock = Current Stock + Qty in Invoice (if edit)
            $availableStock = $product->stock + $currentQtyInInvoice;

            if ($item['quantity'] > $availableStock) {
                $this->addError('items', "الكمية غير متوفرة للمنتج: " . $product->name . " (المتوفر: $availableStock)");
                return;
            }
        }

        // If editing, first restore stock from old items
        if ($this->isEdit) {
            $oldInvoice = SalesInvoice::with('items')->find($this->invoice_id);
            foreach ($oldInvoice->items as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->increment('stock', $oldItem->quantity);
                }
            }
            // Delete old items
            $oldInvoice->items()->delete();
            
            // Update invoice
            $oldInvoice->update([
                'customer_id' => $this->customer_id,
                'invoice_number' => $this->invoice_number,
                'invoice_date' => $this->invoice_date,
                'total_amount' => $this->total_amount,
            ]);
            $invoice = $oldInvoice;
        } else {
            // Create new invoice
            $invoice = SalesInvoice::create([
                'customer_id' => $this->customer_id,
                'invoice_number' => $this->invoice_number,
                'invoice_date' => $this->invoice_date,
                'total_amount' => $this->total_amount,
                'status' => 'approved',
            ]);
        }

        // Add new items and deduct stock
        foreach ($this->items as $item) {
            $invoice->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
            ]);

            $product = Product::find($item['product_id']);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        session()->flash('message', $this->isEdit ? 'تم تحديث الفاتورة بنجاح.' : 'تم إنشاء الفاتورة بنجاح.');
        $this->showModal = false;
        $this->reset(['invoice_id', 'customer_id', 'items', 'total_amount']);
    }

    public function delete($id)
    {
        $invoice = SalesInvoice::with('items')->find($id);
        if ($invoice) {
            // Restore stock
            foreach ($invoice->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
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
