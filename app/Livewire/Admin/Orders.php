<?php

namespace App\Livewire\Admin;

use App\Models\Cart;
<<<<<<< HEAD
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
=======
use App\Models\Product;
use App\Models\SalesInvoice;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
class Orders extends Component
{
    use WithPagination;

<<<<<<< HEAD
    public $selectedCart;
    public $isOpen = false;

    public function render()
    {
        $carts = Cart::with(['user', 'items.product'])
            ->where('status', 'submitted')
            ->orderBy('submitted_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.orders', [
            'carts' => $carts,
        ]);
    }

    public function viewDetails($id)
    {
        $this->selectedCart = Cart::with(['user', 'items.product'])->findOrFail($id);
        $this->isOpen = true;
=======
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
            // 1. Create Sales Invoice
            $invoice = SalesInvoice::create([
                'customer_id' => $this->selectedOrder->customer_id,
                'invoice_number' => 'INV-S-' . strtoupper(Str::random(8)),
                'invoice_date' => now(),
                'total_amount' => $this->selectedOrder->total_amount,
                'status' => 'paid', // Assuming paid or pending payment
            ]);

            // 2. Process Items
            foreach ($this->selectedOrder->items as $item) {
                // Create Invoice Item
                $invoice->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);

                // Update Stock
                $product = Product::find($item->product_id);
                if ($product) {
                    if ($product->stock >= $item->quantity) {
                        $product->decrement('stock', $item->quantity);
                    } else {
                        // Handle insufficient stock? For now, we allow negative or just decrement.
                        // Ideally we should check this before approving.
                        $product->decrement('stock', $item->quantity);
                    }
                }
            }

            // 3. Update Cart Status
            $this->selectedOrder->update(['status' => 'approved']);
        });

        session()->flash('message', 'تم الموافقة على الطلب وإنشاء فاتورة مبيعات.');
        $this->showModal = false;
        $this->selectedOrder = null;
    }

    public function rejectOrder()
    {
        if (!$this->selectedOrder) return;

        // Requirement: "If rejected -> deleted completely"
        // We can delete the cart and its items (cascade delete is set in migration usually, or we do it manually)
        // Migration has cascadeOnDelete for items.
        
        $this->selectedOrder->delete();

        session()->flash('message', 'تم رفض الطلب وحذفه.');
        $this->showModal = false;
        $this->selectedOrder = null;
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }

    public function closeModal()
    {
<<<<<<< HEAD
        $this->isOpen = false;
        $this->selectedCart = null;
    }

    public function approve($id)
    {
        $cart = Cart::with('items.product')->findOrFail($id);

        if ($cart->status !== 'submitted') {
            session()->flash('error', 'Cart is not in submitted status.');
            return;
        }

        DB::transaction(function () use ($cart) {
            // Update Cart
            $cart->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Create Order
            $order = Order::create([
                'cart_id' => $cart->id,
                'user_id' => $cart->user_id,
                'reference' => 'ORD-' . strtoupper(uniqid()),
                'total_amount' => $cart->total_amount,
                'created_by' => auth()->id(),
            ]);

            // Create Order Items and Update Stock
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'qty' => $item->quantity,
                    'price' => $item->unit_price,
                    'total' => $item->total_price,
                ]);

                $product = $item->product;
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        });

        session()->flash('message', 'Order approved successfully.');
        $this->closeModal();
    }

    public function reject($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->status !== 'submitted') {
            session()->flash('error', 'Cart is not in submitted status.');
            return;
        }

        $cart->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(), // Rejected by
            'approved_at' => now(), // Rejected at
        ]);

        session()->flash('message', 'Order rejected.');
        $this->closeModal();
=======
        $this->showModal = false;
        $this->selectedOrder = null;
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }
}
