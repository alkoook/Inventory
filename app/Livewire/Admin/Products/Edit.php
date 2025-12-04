<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use App\Models\InventoryTransaction;
use Livewire\Component;

class Edit extends Component
{
    public $productId;
    public $name = '';
    public $sku = '';
    public $category_id = '';
    public $company_id = '';
    public $purchase_price = 0;
    public $sale_price = 0;
    public $stock = 0;
    public $reorder_level = 0;
    public $description = '';
    public $oldStock = 0;

    public function mount($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->category_id = $product->category_id;
        $this->company_id = $product->company_id;
        $this->purchase_price = $product->purchase_price;
        $this->sale_price = $product->sale_price;
        $this->stock = $product->stock;
        $this->oldStock = $product->stock;
        $this->reorder_level = $product->reorder_level;
        $this->description = $product->description;
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'sku' => 'required|unique:products,sku,' . $this->productId,
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:companies,id',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        $product = Product::findOrFail($this->productId);
        
        // Check if stock changed
        if ($this->stock != $this->oldStock) {
            $difference = $this->stock - $this->oldStock;
            InventoryTransaction::createTransaction(
                $product->id,
                'adjustment',
                abs($difference),
                null,
                null,
                'تعديل المخزون يدوياً',
                auth()->id()
            );
        }

        $product->update([
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

        session()->flash('message', 'تم تحديث المنتج بنجاح.');
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        $categories = Category::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();

        return view('livewire.admin.products.edit', [
            'categories' => $categories,
            'companies' => $companies,
        ])->layout('components.layouts.admin', ['header' => 'تعديل المنتج']);
    }
}
