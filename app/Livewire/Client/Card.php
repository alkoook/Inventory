<?php

namespace App\Livewire\Client;

use App\Models\Cart as CartModel;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Card extends Component
{
    public $showSuccessMessage = false;

    #[On('add-to-cart')]
    public function add(int $productId): void
    {
        $user = Auth::user();

        if (! $user) {
            session()->flash('error', 'يجب تسجيل الدخول أولاً');
            $this->redirect(route('login'), navigate: true);

            return;
        }

        if (! $user->hasRole('customer')) {
            session()->flash('error', 'هذه الميزة متاحة للزبائن فقط');

            return;
        }

        $product = Product::query()
            ->whereKey($productId)
            ->where('is_active', true)
            ->firstOrFail();

        if ($product->stock <= 0) {
            session()->flash('error', 'المنتج غير متوفر في المخزون');

            return;
        }

        DB::transaction(function () use ($user, $product) {
            $cart = CartModel::firstOrCreate([
                'user_id' => $user->id,
                'status' => 'open',
            ], [
                'session_id' => session()->getId(),
            ]);

            $item = CartItem::firstOrNew([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
            ]);

            if (($item->quantity ?? 0) + 1 > $product->stock) {
                session()->flash('error', 'الكمية المطلوبة تتجاوز المخزون المتاح');

                return;
            }

            $item->quantity = ($item->quantity ?? 0) + 1;
            $item->unit_price = $product->sale_price;
            $item->total_price = $item->quantity * $item->unit_price;
            $item->save();

            $cart->total_amount = $cart->items()->sum('total_price');
            $cart->save();
        });

        $this->showSuccessMessage = true;
        $this->dispatch('cart-updated');
        session()->flash('success', 'تم إضافة المنتج إلى السلة بنجاح');
    }

    public function updateQuantity($itemId, $quantity)
    {
        $user = Auth::user();
        if (! $user || ! $user->hasRole('customer')) {
            return;
        }

        $item = CartItem::whereHas('cart', function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('status', 'open');
        })->findOrFail($itemId);

        if ($quantity <= 0) {
            $this->removeItem($itemId);

            return;
        }

        if ($quantity > $item->product->stock) {
            session()->flash('error', 'الكمية المطلوبة تتجاوز المخزون المتاح');

            return;
        }

        $item->quantity = $quantity;
        $item->total_price = $item->quantity * $item->unit_price;
        $item->save();

        $cart = $item->cart;
        $cart->total_amount = $cart->items()->sum('total_price');
        $cart->save();

        $this->dispatch('cart-updated');
    }

    public function removeItem($itemId)
    {
        $user = Auth::user();
        if (! $user || ! $user->hasRole('customer')) {
            return;
        }

        $item = CartItem::whereHas('cart', function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('status', 'open');
        })->findOrFail($itemId);

        $cart = $item->cart;
        $item->delete();

        $cart->total_amount = $cart->items()->sum('total_price');
        $cart->save();

        $this->dispatch('cart-updated');
        session()->flash('success', 'تم حذف المنتج من السلة');
    }

    public function submitOrder()
    {
        $user = Auth::user();
        if (! $user || ! $user->hasRole('customer')) {
            return;
        }

        $cart = CartModel::where('user_id', $user->id)
            ->where('status', 'open')
            ->with('items')
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            session()->flash('error', 'السلة فارغة');

            return;
        }

        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                session()->flash('error', 'بعض المنتجات غير متوفرة بالكمية المطلوبة');

                return;
            }
        }

        $cart->status = 'submitted';
        $cart->submitted_at = now();
        $cart->save();

        $this->dispatch('cart-updated');
        session()->flash('success', 'تم إرسال الطلب بنجاح! في انتظار موافقة الإدارة.');

        return redirect()->route('client.catalog');
    }

    public function render(): \Illuminate\View\View
    {
        $user = Auth::user();
        $cart = null;

        if ($user !== null && $user->hasRole('customer')) {
            $cart = CartModel::query()
                ->with('items.product.category')
                ->where('user_id', $user->id)
                ->where('status', 'open')
                ->first();
        }

        return view('livewire.client.card', [
            'cart' => $cart,
        ])->layout('components.layouts.client', ['title' => 'سلة المشتريات']);
    }
}
