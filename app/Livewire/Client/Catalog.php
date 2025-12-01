<?php

namespace App\Livewire\Client;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Catalog extends Component
{
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
        ])->layout('components.layouts.app');
    }
}
