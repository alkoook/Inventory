<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

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
    public $image;
    public $oldImage;

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
        $this->oldImage = $product->image;
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'sku' => 'required|unique:products,sku,' . $this->productId,
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'nullable|exists:companies,id',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function save()
    {
        $this->validate();

        $product = Product::findOrFail($this->productId);
        
        // Handle image upload
        $imagePath = $this->oldImage;
        if ($this->image) {
            // Delete old image if exists
            if ($this->oldImage && Storage::disk('public')->exists($this->oldImage)) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $imagePath = $this->image->store('products', 'public');
        }
        
        // لا يمكن تعديل المخزون من هنا - المخزون يتم تعديله فقط عبر فواتير الشراء/البيع

        $product->update([
            'name' => $this->name,
            'sku' => $this->sku,
            'category_id' => $this->category_id,
            'company_id' => $this->company_id,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'reorder_level' => $this->reorder_level,
            'description' => $this->description,
            'image' => $imagePath,
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
