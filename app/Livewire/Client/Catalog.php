<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'cat')]
    public $selectedCategory = '';

    #[Url(as: 'company')]
    public $selectedCompany = '';

    #[Url(as: 'sort')]
    public $sortBy = 'latest';

    public array $quantities = [];

    public function mount()
    {
        // Initialize quantities will be done in render
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSelectedCompany()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedCategory', 'selectedCompany', 'sortBy']);
        $this->resetPage();
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

    public function render(): \Illuminate\View\View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        $settings = Setting::all();

        $productsQuery = Product::where('is_active', true)->with(['category', 'company']);

        if ($this->search) {
            $productsQuery->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%')
                    ->orWhere('sku', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->selectedCategory) {
            $productsQuery->where('category_id', $this->selectedCategory);
        }

        if ($this->selectedCompany) {
            $productsQuery->where('company_id', $this->selectedCompany);
        }

        switch ($this->sortBy) {
            case 'price_asc': $productsQuery->orderBy('sale_price', 'asc');
                break;
            case 'price_desc': $productsQuery->orderBy('sale_price', 'desc');
                break;
            case 'name_asc': $productsQuery->orderBy('name', 'asc');
                break;
            case 'name_desc': $productsQuery->orderBy('name', 'desc');
                break;
            case 'latest': default: $productsQuery->latest();
                break;
        }

        $products = $productsQuery->paginate(12);

        // Initialize quantities for products that don't have one
        foreach ($products as $product) {
            if (!isset($this->quantities[$product->id])) {
                $this->quantities[$product->id] = 1;
            }
        }

        return view('livewire.client.catalog', [
            'categories' => $categories,
            'companies' => $companies,
            'products' => $products,
            'settings' => $settings,
        ])->layout('components.layouts.client');
    }
}
