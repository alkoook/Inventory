<?php

namespace App\Livewire\Client;

use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        
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

        // Check if product already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Increment quantity
            $cartItem->quantity += 1;
            $cartItem->total_price = $cartItem->quantity * $cartItem->unit_price;
            $cartItem->save();
        } else {
            // Add new item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
                'unit_price' => $product->sale_price,
                'total_price' => $product->sale_price,
            ]);
        }

        // Update cart total
        $cart->total_amount = $cart->items()->sum('total_price');
        $cart->save();

        session()->flash('message', 'تم إضافة المنتج للسلة بنجاح!');
    }

    public function render(): \Illuminate\View\View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->where('is_active', true)
            ->with(['category', 'company'])
            ->latest()
            ->paginate(12);

        return view('livewire.client.catalog', [
            'categories' => $categories,
            'products' => $products,
        ])->layout('components.layouts.client');
    }
}
