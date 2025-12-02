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
        $this->addItem();
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
        $this->invoice_number = 'INV-S-' . strtoupper(Str::random(8));
        $this->invoice_date = now()->format('Y-m-d');
        $this->items = [];
        $this->addItem();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        // Editing sales invoices is tricky because of stock. 
        // For simplicity, we might restrict editing or handle stock reversal.
        // Let's allow editing but be careful.
        
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

        if ($field === 'product_id') {
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

        // Check stock availability for new/updated items
        // This is complex for edit, so let's simplify: 
        // If edit: revert old stock, check new stock.
        
        if ($this->isEdit) {
            $invoice = SalesInvoice::with('items')->find($this->invoice_id);
            foreach ($invoice->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) $product->increment('stock', $item->quantity);
            }
        }

        // Check stock
        foreach ($this->items as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stock < $item['quantity']) {
                // Revert stock if we were editing and failed here? 
                // This is getting transaction-heavy.
                // For now, just fail validation.
                $this->addError('items', "الكمية غير متوفرة للمنتج: " . ($product->name ?? ''));
                
                // If we reverted stock above, we must re-decrement it if we fail here? 
                // Ideally use DB transaction.
                if ($this->isEdit) {
                     // Re-decrement what we incremented
                     $invoice = SalesInvoice::with('items')->find($this->invoice_id);
                     foreach ($invoice->items as $oldItem) {
                         $p = Product::find($oldItem->product_id);
                         if ($p) $p->decrement('stock', $oldItem->quantity);
                     }
                }
                return;
            }
        }

        $data = [
            'customer_id' => $this->customer_id,
            'invoice_number' => $this->invoice_number,
            'invoice_date' => $this->invoice_date,
            'total_amount' => $this->total_amount,
            'status' => 'paid',
        ];

        if ($this->isEdit) {
            $invoice = SalesInvoice::find($this->invoice_id);
            $invoice->update($data);
            $invoice->items()->delete();
        } else {
            $invoice = SalesInvoice::create($data);
        }

        foreach ($this->items as $item) {
            $invoice->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
            ]);

            // Decrement Stock
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
            // Revert stock
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
