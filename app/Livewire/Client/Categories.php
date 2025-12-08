<?php

namespace App\Livewire\Client;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public function render()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('livewire.client.categories', [
            'categories' => $categories,
        ])->layout('components.layouts.client', ['title' => 'الأصناف - متجر المخزون']);
    }
}
