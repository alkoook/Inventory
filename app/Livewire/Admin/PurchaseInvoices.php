<?php

namespace App\Livewire\Admin;

use App\Models\Company;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class PurchaseInvoices extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $viewOpen = false;
    public $selectedInvoice;

    // Form Fields
    public $company_id;
    public $invoice_date;
    public $notes;
    public $items = [];

    public function mount()
    {
        $this->invoice_date = date('Y-m-d');
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) === 2 && $parts[1] === 'product_id') {
            $index = $parts[0];
            $productId = $value;
            $product = Product::find($productId);
            if ($product) {
                $this->items[$index]['unit_price'] = $product->purchase_price;
            }
        }
    }

    public function render()
    {
        $invoices = PurchaseInvoice::with('company')
            ->whereHas('company', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('invoice_number', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $companies = Company::all();
        $products = Product::where('is_active', true)->get();

        return view('livewire.admin.purchase-invoices', [
            'invoices' => $invoices,
            'companies' => $companies,
            'products' => $products,
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->viewOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->company_id = '';
        $this->invoice_date = date('Y-m-d');
        $this->notes = '';
        $this->items = [];
        $this->addItem();
        $this->selectedInvoice = null;
    }

    public function store()
    {
        $this->validate([
            'company_id' => 'required',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            $totalAmount = 0;
            foreach ($this->items as $item) {
                $totalAmount += $item['quantity'] * $item['unit_price'];
            }

            $invoice = PurchaseInvoice::create([
                'company_id' => $this->company_id,
                'invoice_number' => 'PUR-' . strtoupper(uniqid()),
                'invoice_date' => $this->invoice_date,
                'total_amount' => $totalAmount,
                'status' => 'approved', // Auto approve for now
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

                // Increment Stock & Update Cost
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                    $product->update(['purchase_price' => $item['unit_price']]);
                }
            }
        });

        session()->flash('message', 'Purchase Invoice Created Successfully.');
        $this->closeModal();
    }

    public function view($id)
    {
        $this->selectedInvoice = PurchaseInvoice::with(['company', 'items.product'])->findOrFail($id);
        $this->viewOpen = true;
    }

    public function delete($id)
    {
        PurchaseInvoice::find($id)->delete();
        session()->flash('message', 'Invoice Deleted Successfully.');
    }
}
