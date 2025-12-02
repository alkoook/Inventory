<?php

namespace App\Livewire\Client;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

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

        if (!$user) {
            return $this->redirect(route('login'), navigate: true);
        }

        if ($user->role !== 'customer') {
            session()->flash('error', 'هذه الميزة متاحة للزبائن فقط');
            return;
        }

        $product = Product::find($productId);
        if (!$product || $product->stock <= 0) {
            return;
        }

        // Get or create customer
        $customer = Customer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'is_active' => true,
            ]
        );

        DB::transaction(function () use ($customer, $product) {
            $cart = Cart::firstOrCreate([
                'customer_id' => $customer->id,
                'status' => 'open',
            ]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                if ($cartItem->quantity < $product->stock) {
                    $cartItem->increment('quantity');
                    $cartItem->update(['total_price' => $cartItem->quantity * $cartItem->unit_price]);
                }
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'unit_price' => $product->sale_price,
                    'total_price' => $product->sale_price,
                ]);
            }

            // Update cart total
            $cart->update([
                'total_amount' => $cart->items()->sum('total_price')
            ]);
        });

        $this->dispatch('cart-updated'); // Update the navbar counter
        session()->flash('success', 'تمت الإضافة للسلة');
    }

    public function render(): \Illuminate\View\View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $companies = Company::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            $setiings=Setting::all();

        $productsQuery = Product::query()
            ->where('is_active', true)
            ->with(['category', 'company']);

        // Search
        if (!empty($this->search)) {
            $productsQuery->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by category
        if (!empty($this->selectedCategory)) {
            $productsQuery->where('category_id', $this->selectedCategory);
        }

        // Filter by company
        if (!empty($this->selectedCompany)) {
            $productsQuery->where('company_id', $this->selectedCompany);
        }

        // Sort
        switch ($this->sortBy) {
            case 'price_asc':
                $productsQuery->orderBy('sale_price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('sale_price', 'desc');
                break;
            case 'name_asc':
                $productsQuery->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $productsQuery->orderBy('name', 'desc');
                break;
            case 'latest':
            default:
                $productsQuery->latest();
                break;
        }

        $products = $productsQuery->paginate(12);
        $settings=Setting::all();

        return view('livewire.client.catalog', [
            'categories' => $categories,
            'companies' => $companies,
            'products' => $products,
            'settings' => $settings,
        ])->layout('components.layouts.app');
    }
}
