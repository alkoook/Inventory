<?php

namespace App\Livewire\Admin;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SalesInvoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedOrder;
    public $showModal = false;

    public function render()
    {
        $orders = Cart::with(['customer.user', 'items.product'])
            ->where('status', '!=', 'open') // Only show submitted/processed orders
            ->where(function ($q) {
                $q->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.orders', [
            'orders' => $orders,
        ])->layout('components.layouts.admin', ['header' => 'طلبات الزبائن']);
    }

    public function viewOrder($id)
    {
        $this->selectedOrder = Cart::with(['customer.user', 'items.product'])->findOrFail($id);
        $this->showModal = true;
    }

    public function approveOrder()
    {
        if (!$this->selectedOrder) return;

        DB::transaction(function () {
            // Create Sales Invoice
            $invoice = SalesInvoice::create([
                'customer_id' => $this->selectedOrder->customer_id,
                'invoice_number' => 'INV-S-' . strtoupper(Str::random(8)),
                'invoice_date' => now(),
                'total_amount' => $this->selectedOrder->total_amount,
                'status' => 'paid',
            ]);

            // Process Items
            foreach ($this->selectedOrder->items as $item) {
                $invoice->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);

                // Update Stock
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            // Update Cart Status
            $this->selectedOrder->update(['status' => 'approved']);
        });

        session()->flash('message', 'تم الموافقة على الطلب وإنشاء فاتورة مبيعات.');
        $this->showModal = false;
        $this->selectedOrder = null;
    }

    public function rejectOrder()
    {
        if (!$this->selectedOrder) return;

        // Delete order and items
        $this->selectedOrder->delete();

        session()->flash('message', 'تم رفض الطلب وحذفه.');
        $this->showModal = false;
        $this->selectedOrder = null;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedOrder = null;
    }
}
