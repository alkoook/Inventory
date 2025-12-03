<?php

namespace App\Livewire\Client;

use App\Models\Cart as CartModel;
use App\Models\CartItem;
<<<<<<< HEAD
=======
use App\Models\Customer;
use App\Models\Product;
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class Card extends Component
{
<<<<<<< HEAD
    public function increment($itemId)
=======
    public $showSuccessMessage = false;

    #[On('add-to-cart')]
    public function add(int $productId): void
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    {
        $item = CartItem::find($itemId);
        if ($item) {
            $item->quantity++;
            $item->total_price = $item->quantity * $item->unit_price;
            $item->save();
            $this->updateCartTotal($item->cart_id);
        }
    }

<<<<<<< HEAD
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
=======
        if ($user === null) {
            session()->flash('error', 'يجب تسجيل الدخول أولاً');
            $this->redirect(route('login'), navigate: true);
            return;
        }

        if ($user->role !== 'customer') {
            session()->flash('error', 'هذه الميزة متاحة للزبائن فقط');
            return;
        }

        // Get or create customer record
        $customer = Customer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => '',
                'address' => '',
                'is_active' => true,
            ]
        );

        $product = Product::query()
            ->whereKey($productId)
            ->where('is_active', true)
            ->firstOrFail();

        // Check stock
        if ($product->stock <= 0) {
            session()->flash('error', 'المنتج غير متوفر في المخزون');
            return;
        }

        DB::transaction(function () use ($customer, $product) {
            $cart = Cart::firstOrCreate([
                'customer_id' => $customer->id,
                'status' => 'open',
            ]);

            $item = CartItem::firstOrNew([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
            ]);

            // Check if adding one more exceeds stock
            if ($item->quantity + 1 > $product->stock) {
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
        if (!$user || $user->role !== 'customer') {
            return;
        }

        $customer = $user->customer;
        if (!$customer) {
            return;
        }

        $item = CartItem::whereHas('cart', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id)
              ->where('status', 'open');
        })->findOrFail($itemId);

        if ($quantity <= 0) {
            $this->removeItem($itemId);
            return;
        }

        // Check stock
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
        if (!$user || $user->role !== 'customer') {
            return;
        }

        $customer = $user->customer;
        if (!$customer) {
            return;
        }

        $item = CartItem::whereHas('cart', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id)
              ->where('status', 'open');
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
        if (!$user || $user->role !== 'customer') {
            return;
        }

        $customer = $user->customer;
        if (!$customer) {
            return;
        }

        $cart = Cart::where('customer_id', $customer->id)
            ->where('status', 'open')
            ->with('items')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            session()->flash('error', 'السلة فارغة');
            return;
        }

        // Check stock for all items
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                session()->flash('error', 'بعض المنتجات غير متوفرة بالكمية المطلوبة');
                return;
            }
        }

        // Update cart status to pending (submitted for approval)
        $cart->status = 'pending';
        $cart->save();

        $this->dispatch('cart-updated');
        session()->flash('success', 'تم إرسال الطلب بنجاح! في انتظار موافقة الإدارة.');
        
        $this->redirect(route('client.catalog'), navigate: true);
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }

    public function render(): \Illuminate\View\View
    {
<<<<<<< HEAD
        $cart = $this->getCart();

        return view('livewire.client.card', [
            'cart' => $cart,
        ])->layout('components.layouts.client');
=======
        $user = Auth::user();

        $cart = null;

        if ($user !== null && $user->role === 'customer') {
            // Get or create customer
            $customer = Customer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => '',
                    'address' => '',
                    'is_active' => true,
                ]
            );

            $cart = Cart::query()
                ->with('items.product.category')
                ->where('customer_id', $customer->id)
                ->where('status', 'open')
                ->first();
        }

        return view('livewire.client.card', [
            'cart' => $cart,
        ])->layout('components.layouts.app', ['title' => 'سلة المشتريات']);
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }
}
