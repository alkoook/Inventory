<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Company;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name = '';

    public $sku = '';

    public $category_id = '';

    public $company_id = '';

    public $purchase_price = 0;

    public $sale_price = 0;

    public $stock = 0;

    public $reorder_level = 0;

    public $description = '';

    public $image;

    public $unit_of_measure = 'قطعة';

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'sku' => 'required|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'nullable|exists:companies,id',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'unit_of_measure' => 'required|in:غرام,كيلو,قطعة,علبة,كيس,ظرف,تنكة,طرد',
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // 1. حفظ الصورة
                $imagePath = null;
                if ($this->image) {
                    $imagePath = $this->image->store('products', 'public');
                }

                // 2. إنشاء المنتج بدون مخزون أولي (سيتم إضافته عبر transaction)
                $product = Product::create([
                    'name' => $this->name,
                    'sku' => $this->sku,
                    'category_id' => $this->category_id,
                    'company_id' => $this->company_id,
                    'purchase_price' => $this->purchase_price,
                    'sale_price' => $this->sale_price,
                    'stock' => 0, // بدء من صفر، سيتم تحديثه عبر transaction
                    'reorder_level' => $this->reorder_level,
                    'description' => $this->description,
                    'image' => $imagePath,
                    'unit_of_measure' => $this->unit_of_measure,
                    'is_active' => true,
                ]);

                // 3. إذا كان هناك مخزون أولي، إنشاء فاتورة شراء تلقائياً
                if ($this->stock > 0 && $this->company_id) {
                    // إنشاء فاتورة الشراء
                    $invoice = PurchaseInvoice::create([
                        'company_id' => $this->company_id,
                        'invoice_number' => 'PINV-'.now()->format('YmdHis'),
                        'invoice_date' => now()->toDateString(),
                        'total_amount' => $this->stock * $this->purchase_price,
                        'notes' => 'فاتورة شراء تلقائية عند إضافة منتج جديد: '.$this->name,
                    ]);

                    // إضافة صنف الفاتورة
                    PurchaseInvoiceItem::create([
                        'purchase_invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                        'quantity' => $this->stock,
                        'unit_of_measure' => $this->unit_of_measure,
                        'unit_price' => $this->purchase_price,
                        'total_price' => $this->stock * $this->purchase_price,
                    ]);

                    // إنشاء معاملة المخزون (ستضيف الكمية تلقائياً)
                    InventoryTransaction::createTransaction(
                        $product->id,
                        'purchase',
                        $this->stock,
                        'App\Models\PurchaseInvoice',
                        $invoice->id,
                        'شراء - فاتورة تلقائية: '.$invoice->invoice_number
                    );
                } elseif ($this->stock > 0 && !$this->company_id) {
                    // إذا كان هناك مخزون أولي بدون شركة، إنشاء معاملة adjustment مباشرة
                    InventoryTransaction::createTransaction(
                        $product->id,
                        'adjustment',
                        $this->stock,
                        null,
                        null,
                        'مخزون أولي - منتج بدون شركة: '.$this->name,
                        auth()->id()
                    );
                }
            });

            session()->flash('message', 'تم إضافة المنتج بنجاح'.($this->stock > 0 ? ' وإنشاء فاتورة الشراء تلقائياً' : '').'.');

            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء حفظ المنتج: '.$e->getMessage());
        }
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
