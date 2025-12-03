<?php

namespace App\Livewire\Client;

use App\Models\Cart as CartModel;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Card extends Component
{
    public function increment($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item) {
            $item->quantity++;
            $item->total_price = $item->quantity * $item->unit_price;
            $item->save();
            $this->updateCartTotal($item->cart_id);
        }
    }

    public function decrement($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item && $item->quantity > 1) {
            $item->quantity--;
            $item->total_price = $item->quantity * $item->unit_price;
            $item->save();
            $this->updateCartTotal($item->cart_id);
        }
    }

    public function remove($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item) {
            $cartId = $item->cart_id;
            $item->delete();
            $this->updateCartTotal($cartId);
        }
    }

    protected function updateCartTotal($cartId)
    {
        $cart = CartModel::find($cartId);
        if ($cart) {
            $cart->total_amount = $cart->items()->sum('total_price');
            $cart->save();
        }
    }

    public function submit()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = $this->getCart();

        if ($cart && $cart->items()->count() > 0) {
            $cart->update([
                'status' => 'submitted',
                'submitted_at' => now(),
                'user_id' => Auth::id(), // Ensure user_id is set
            ]);

            session()->flash('message', 'تم إرسال الطلب للاعتماد بنجاح!');
            return redirect()->route('client.catalog');
        }
    }

    public function getCart()
    {
        if (Auth::check()) {
            return CartModel::where('user_id', Auth::id())
                ->where('status', 'draft')
                ->with('items.product')
                ->first();
        } else {
            return CartModel::where('session_id', session()->getId())
                ->where('status', 'draft')
                ->with('items.product')
                ->first();
        }
    }

    public function render(): \Illuminate\View\View
    {
        $cart = $this->getCart();

        return view('livewire.client.card', [
            'cart' => $cart,
        ])->layout('components.layouts.client');
    }
}
