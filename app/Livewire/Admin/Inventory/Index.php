<?php

namespace App\Livewire\Admin\Inventory;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%');
            })
            ->orderBy('stock', 'asc') // Show low stock first
            ->paginate(10);

        return view('livewire.admin.inventory.index', [
            'products' => $products
        ])->layout('components.layouts.admin');
    }
}
