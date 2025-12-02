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
        $categories = Category::withCount('products')->paginate(12);

        return view('livewire.client.categories', [
            'categories' => $categories
        ])->layout('components.layouts.app', ['title' => 'الأصناف - متجر المخزون']);
    }
}
