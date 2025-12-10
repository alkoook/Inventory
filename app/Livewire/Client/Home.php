<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Home extends Component
{
    public array $quantities = [];
    
    public $search = '';

    public function mount()
    {
        // Initialize quantities for all products
        $products = Product::where('is_active', true)->latest()->take(24)->get();
        foreach ($products as $product) {
            $this->quantities[$product->id] = 1;
        }
    }

    public function increment($productId)
    {
        $product = Product::find($productId);
        if ($product && isset($this->quantities[$productId]) && $this->quantities[$productId] < $product->stock) {
            $this->quantities[$productId]++;
        }
    }

    public function decrement($productId)
    {
        if (isset($this->quantities[$productId]) && $this->quantities[$productId] > 1) {
            $this->quantities[$productId]--;
        }
    }

    public function addToCart($productId): void
    {
        $user = Auth::user();

        if (! $user) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $product = Product::find($productId);
        if (! $product || $product->stock <= 0) {
            session()->flash('error', 'المنتج غير متوفر');

            return;
        }

        if (! $user->hasRole('customer')) {
            session()->flash('error', 'هذه الميزة متاحة للزبائن فقط');
            return;
        }

        $quantity = $this->quantities[$productId] ?? 1;

        if ($quantity > $product->stock) {
            session()->flash('error', 'الكمية المطلوبة تتجاوز المخزون المتاح');
            return;
        }

        DB::transaction(function () use ($user, $product, $quantity) {
            $cart = Cart::firstOrCreate([
                'user_id' => $user->id,
                'status' => 'open',
            ], [
                'session_id' => session()->getId(),
            ]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $quantity;
                if ($newQuantity > $product->stock) {
                    session()->flash('error', 'الكمية الإجمالية تتجاوز المخزون المتاح');
                    return;
                }
                $cartItem->quantity = $newQuantity;
                $cartItem->update(['total_price' => $cartItem->quantity * $cartItem->unit_price]);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->sale_price,
                    'total_price' => $quantity * $product->sale_price,
                ]);
            }

            $cart->update(['total_amount' => $cart->items()->sum('total_price')]);
        });

        // Reset quantity after adding
        $this->quantities[$productId] = 1;

        $this->dispatch('cart-updated');
        session()->flash('success', 'تمت الإضافة للسلة بنجاح');
    }

    #[Layout('components.layouts.client')]
    public function render()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $companies = Company::where('is_active', true)
            ->orderBy('name')
            ->get();

        $latestProducts = Product::where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%');
            })
            ->with(['category', 'company'])
            ->latest()
            ->take(24)
            ->get();

        return view('livewire.client.home', [
            'categories' => $categories,
            'companies' => $companies,
            'latestProducts' => $latestProducts,
        ]);
    }
}
