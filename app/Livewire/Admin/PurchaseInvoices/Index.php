<?php

namespace App\Livewire\Admin\PurchaseInvoices;

use App\Models\PurchaseInvoice;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $invoices = PurchaseInvoice::with('company')
            ->where('invoice_number', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.purchase-invoices.index', [
            'invoices' => $invoices,
        ])->layout('components.layouts.admin', ['header' => 'فواتير المشتريات']);
    }

    public function delete($id)
    {
        $invoice = PurchaseInvoice::with('items')->findOrFail($id);
        
        // Return stock
        foreach ($invoice->items as $item) {
            \App\Models\InventoryTransaction::createTransaction(
                $item->product_id,
                'return_purchase',
                $item->quantity,
                'App\Models\PurchaseInvoice',
                $id,
                'إرجاع مخزون - حذف فاتورة: ' . $invoice->invoice_number
            );
        }
        
        $invoice->delete();
        session()->flash('message', 'تم حذف الفاتورة واسترجاع المخزون.');
    }
}
