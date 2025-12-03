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
        // Get or create cart for current session or user
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'status' => 'draft'
                ],
                [
                    'session_id' => session()->getId(),
                    'total_amount' => 0
                ]
            );
        } else {
            $cart = Cart::firstOrCreate(
                [
                    'session_id' => session()->getId(),
                    'status' => 'draft'
                ],
                [
                    'total_amount' => 0
                ]
            );
        }

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $this->product->id,
        ]);

        $item->quantity = ($item->quantity ?? 0) + $this->quantity;
        $item->unit_price = $this->product->sale_price;
        $item->total_price = $item->quantity * $item->unit_price;
        $item->save();

        $cart->total_amount = $cart->items()->sum('total_price');
        $cart->save();

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
        ])->layout('components.layouts.client');
    }
}
