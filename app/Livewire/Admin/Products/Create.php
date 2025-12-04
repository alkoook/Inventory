<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use App\Models\InventoryTransaction;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $sku = '';
    public $category_id = '';
    public $company_id = '';
    public $purchase_price = 0;
    public $sale_price = 0;
    public $stock = 0;
    public $reorder_level = 0;
    public $description = '';

    protected $rules = [
        'name' => 'required|min:3',
        'sku' => 'required|unique:products,sku',
        'category_id' => 'required|exists:categories,id',
        'company_id' => 'required|exists:companies,id',
        'purchase_price' => 'required|numeric|min:0',
        'sale_price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'reorder_level' => 'nullable|integer|min:0',
        'description' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        $product = Product::create([
            'name' => $this->name,
            'sku' => $this->sku,
            'category_id' => $this->category_id,
            'company_id' => $this->company_id,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
            'reorder_level' => $this->reorder_level,
            'description' => $this->description,
        ]);

        // Create initial inventory transaction
        if ($this->stock > 0) {
            InventoryTransaction::createTransaction(
                $product->id,
                'adjustment',
                $this->stock,
                null,
                null,
                'المخزون الأولي عند إنشاء المنتج',
                auth()->id()
            );
        }

        session()->flash('message', 'تم إضافة المنتج بنجاح.');
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        $categories = Category::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();

        return view('livewire.admin.products.create', [
            'categories' => $categories,
            'companies' => $companies,
        ])->layout('components.layouts.admin', ['header' => 'إضافة منتج جديد']);
    }
}
