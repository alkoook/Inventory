<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Products extends Component
{
    use WithPagination;

    public $name;
    public $sku;
    public $description;
    public $purchase_price;
    public $sale_price;
    public $stock = 0;
    public $reorder_level = 5;
    public $category_id;
    public $company_id;
    public $is_active = true;
    
    public $selected_id;
    public $search = '';

    protected $rules = [
        'name' => 'required|min:3',
        'sku' => 'required|unique:products,sku',
        'description' => 'nullable',
        'purchase_price' => 'required|numeric|min:0',
        'sale_price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'company_id' => 'required|exists:companies,id',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $products = Product::with(['category', 'company'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        $categories = Category::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();

        return view('livewire.admin.products', [
            'products' => $products,
            'categories' => $categories,
            'companies' => $companies,
        ])->layout('components.layouts.admin', ['header' => 'إدارة المنتجات']);
    }

    public function create()
    {
        $this->reset(['name', 'sku', 'description', 'purchase_price', 'sale_price', 'stock', 'reorder_level', 'category_id', 'company_id', 'is_active', 'selected_id']);
        $this->sku = 'SKU-' . strtoupper(Str::random(8));
    }

    public function edit($id)
    {
        $record = Product::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->sku = $record->sku;
        $this->description = $record->description;
        $this->purchase_price = $record->purchase_price;
        $this->sale_price = $record->sale_price;
        $this->stock = $record->stock;
        $this->reorder_level = $record->reorder_level;
        $this->category_id = $record->category_id;
        $this->company_id = $record->company_id;
        $this->is_active = $record->is_active;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->selected_id) {
            $rules['sku'] = 'required|unique:products,sku,' . $this->selected_id;
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
            'reorder_level' => $this->reorder_level,
            'category_id' => $this->category_id,
            'company_id' => $this->company_id,
            'is_active' => $this->is_active,
        ];

        if ($this->selected_id) {
            Product::find($this->selected_id)->update($data);
            session()->flash('message', 'تم تحديث المنتج بنجاح.');
        } else {
            Product::create($data);
            session()->flash('message', 'تم إضافة المنتج بنجاح.');
        }

        $this->reset(['name', 'sku', 'description', 'purchase_price', 'sale_price', 'stock', 'reorder_level', 'category_id', 'company_id', 'is_active', 'selected_id']);
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'تم حذف المنتج بنجاح.');
    }
}
