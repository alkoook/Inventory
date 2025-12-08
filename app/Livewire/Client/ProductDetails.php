<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProductDetails extends Component
{
    public Product $product;
    public int $quantity = 1;

    public function mount(Product $product)
    {
        $this->product = $product;

        if (! $this->product->is_active) {
            abort(404);
        }
    }

    public function increment()
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        $user = Auth::user();

        if (! $user) {
            session()->flash('error', 'يجب تسجيل الدخول أولاً');
            return $this->redirect(route('login'), navigate: true);
        }

        // Check if user has customer role using Spatie permissions
        if (! $user->hasRole('customer')) {
            session()->flash('error', 'هذه الميزة متاحة للزبائن فقط');
            return;
        }

        if ($this->product->stock <= 0) {
            session()->flash('error', 'المنتج غير متوفر في المخزون');
            return;
        }

        if ($this->quantity > $this->product->stock) {
            session()->flash('error', 'الكمية المطلوبة تتجاوز المخزون المتاح');
            return;
        }

        try {
            DB::transaction(function () use ($user) {
                $cart = Cart::firstOrCreate([
                    'user_id' => $user->id,
                    'status' => 'open',
                ], [
                    'session_id' => session()->getId(),
                    'total_amount' => 0,
                ]);

                $item = CartItem::firstOrNew([
                    'cart_id' => $cart->id,
                    'product_id' => $this->product->id,
                ]);

                $newQuantity = ($item->quantity ?? 0) + $this->quantity;
                
                if ($newQuantity > $this->product->stock) {
                    session()->flash('error', 'الكمية الإجمالية تتجاوز المخزون المتاح');
                    return;
                }

                $item->quantity = $newQuantity;
                $item->unit_price = $this->product->sale_price;
                $item->total_price = $item->quantity * $item->unit_price;
                $item->save();

                $cart->total_amount = $cart->items()->sum('total_price');
                $cart->save();
            });

            $this->dispatch('cart-updated');
            session()->flash('message', 'تم إضافة المنتج للسلة بنجاح');
            $this->quantity = 1; // Reset quantity
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء إضافة المنتج للسلة');
        }
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
