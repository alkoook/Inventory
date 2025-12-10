<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;
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
        try {
            DB::transaction(function () use ($id) {
                $product = Product::findOrFail($id);
                
                // 1. جلب جميع فواتير الشراء المرتبطة بهذا المنتج
                $purchaseInvoiceItems = PurchaseInvoiceItem::where('product_id', $id)->get();
                
                // 2. حذف كل item وإرجاع المخزون وحذف الفواتير الفارغة
                $invoicesToCheck = [];
                
                foreach ($purchaseInvoiceItems as $item) {
                    $invoice = $item->purchaseInvoice;
                    
                    // إرجاع المخزون المرتبط بفاتورة الشراء (حذف معاملات المخزون)
                    InventoryTransaction::where('reference_type', 'App\Models\PurchaseInvoice')
                        ->where('reference_id', $invoice->id)
                        ->where('product_id', $id)
                        ->delete();
                    
                    // إرجاع المخزون من المنتج (تقليل المخزون)
                    if ($invoice && $item->quantity > 0) {
                        $product->decrement('stock', $item->quantity);
                    }
                    
                    // حذف الـ item
                    $item->delete();
                    
                    // تتبع الفواتير للتحقق منها لاحقاً
                    if ($invoice && !in_array($invoice->id, $invoicesToCheck)) {
                        $invoicesToCheck[] = $invoice->id;
                    }
                }
                
                // 3. التحقق من الفواتير وحذف الفارغة
                foreach ($invoicesToCheck as $invoiceId) {
                    $invoice = PurchaseInvoice::with('items')->find($invoiceId);
                    if ($invoice && $invoice->items()->count() === 0) {
                        // حذف الفاتورة الفارغة
                        $invoice->delete();
                    } else if ($invoice) {
                        // إعادة حساب إجمالي الفاتورة
                        $totalAmount = $invoice->items()->sum('total_price');
                        $invoice->update(['total_amount' => $totalAmount]);
                    }
                }
                
                // 4. حذف جميع معاملات المخزون المرتبطة بالمنتج
                InventoryTransaction::where('product_id', $id)->delete();
                
                // 5. حذف المنتج
                $product->delete();
            });
            
            session()->flash('message', 'تم حذف المنتج وفواتير الشراء المرتبطة به بنجاح.');
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء حذف المنتج: ' . $e->getMessage());
        }
    }
}
