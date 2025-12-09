<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyDetails extends Component
{
    use WithPagination;

    public Company $company;
    public array $quantities = [];

    public function mount(Company $company)
    {
        $this->company = $company;

        if (! $this->company->is_active) {
            abort(404);
        }
    }

    public function increment($productId)
    {
        $product = Product::find($productId);
        if ($product && isset($this->quantities[$productId]) && $this->quantities[$productId] < $product->stock) {
            $this->quantities[$productId]++;
        } elseif ($product && !isset($this->quantities[$productId])) {
            $this->quantities[$productId] = 1;
        }
    }

    public function decrement($productId)
    {
        if (isset($this->quantities[$productId]) && $this->quantities[$productId] > 1) {
            $this->quantities[$productId]--;
        }
    }

    public function addToCart($productId)
    {
        $user = Auth::user();

        if (! $user) {
            return $this->redirect(route('login'), navigate: true);
        }

        if (! $user->hasRole('customer')) {
            session()->flash('error', 'هذه الميزة متاحة للزبائن فقط');

            return;
        }

        $product = Product::find($productId);
        if (! $product || $product->stock <= 0) {
            session()->flash('error', 'المنتج غير متوفر');

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
        session()->flash('success', 'تمت الإضافة للسلة');
    }

    public function render()
    {
        $products = Product::query()
            ->where('company_id', $this->company->id)
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        // Initialize quantities for products that don't have one
        foreach ($products as $product) {
            if (!isset($this->quantities[$product->id])) {
                $this->quantities[$product->id] = 1;
            }
        }

        return view('livewire.client.company-details', [
            'products' => $products,
        ])->layout('components.layouts.client');
    }
}
