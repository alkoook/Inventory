<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductDetails extends Component
{
    public Product $product;
    public int $quantity = 1;

    public function mount(Product $product)
    {
        $this->product = $product;
        
        if (!$this->product->is_active) {
            abort(404);
        }
    }

    public function addToCart()
    {
        $user = Auth::user();

        if ($user === null || $user->role !== 'customer') {
            // Redirect to login or show error
            return;
        }

        $cart = Cart::firstOrCreate([
            'customer_id' => $user->customer->id ?? null,
            'status' => 'open',
        ]);

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $this->product->id,
        ]);

        $item->quantity = $item->quantity + $this->quantity;
        $item->unit_price = $this->product->sale_price;
        $item->total_price = $item->quantity * $item->unit_price;
        $item->save();

        $cart->total_amount = $cart->items()->sum('total_price');
        $cart->save();

        $this->dispatch('cart-updated'); // Optional: if we have a cart counter
        session()->flash('message', 'تم إضافة المنتج للسلة بنجاح');
    }

    public function render()
    {
        $relatedProducts = Product::query()
            ->where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('livewire.client.product-details', [
            'relatedProducts' => $relatedProducts,
        ])->layout('components.layouts.app');
    }
}
