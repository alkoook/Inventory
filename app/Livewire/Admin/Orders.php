<?php

namespace App\Livewire\Admin;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Orders extends Component
{
    use WithPagination;

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
    }

    public function closeModal()
    {
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
    }
}
