<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $products = Product::with(['category', 'company'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.products.index', [
            'products' => $products,
        ])->layout('components.layouts.admin', ['header' => 'المنتجات']);
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'تم حذف المنتج بنجاح.');
    }
}
