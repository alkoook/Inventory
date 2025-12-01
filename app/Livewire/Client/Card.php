<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Card extends Component
{
    public function add(int $productId): void
    {
        $user = Auth::user();

        if ($user === null || $user->role !== 'customer') {
            return;
        }

        $product = Product::query()
            ->whereKey($productId)
            ->where('is_active', true)
            ->firstOrFail();

        $cart = Cart::firstOrCreate([
            'customer_id' => $user->customer->id ?? null,
            'status' => 'open',
        ]);

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $item->quantity = $item->quantity + 1;
        $item->unit_price = $product->sale_price;
        $item->total_price = $item->quantity * $item->unit_price;
        $item->save();

        $cart->total_amount = $cart->items()->sum('total_price');
        $cart->save();
    }

    public function render(): \Illuminate\View\View
    {
        $user = Auth::user();

        $cart = null;

        if ($user !== null && $user->role === 'customer' && $user->customer !== null) {
            $cart = Cart::query()
                ->with('items.product')
                ->where('customer_id', $user->customer->id)
                ->where('status', 'open')
                ->first();
        }

        return view('livewire.client.card', [
            'cart' => $cart,
        ])->layout('components.layouts.app');
    }
}
