<?php

namespace App\Livewire\Admin\SalesInvoices;

use App\Models\SalesInvoice;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $invoices = SalesInvoice::with('user')
            ->where('invoice_number', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.sales-invoices.index', [
            'invoices' => $invoices,
        ])->layout('components.layouts.admin', ['header' => 'فواتير المبيعات']);
    }

    public function delete($id)
    {
        $invoice = SalesInvoice::with('items')->findOrFail($id);
        
        // Return stock
        foreach ($invoice->items as $item) {
            \App\Models\InventoryTransaction::createTransaction(
                $item->product_id,
                'return_sale',
                $item->quantity,
                'App\Models\SalesInvoice',
                $id,
                'إرجاع مخزون - حذف فاتورة: ' . $invoice->invoice_number
            );
        }
        
        $invoice->delete();
        session()->flash('message', 'تم حذف الفاتورة واسترجاع المخزون.');
    }
}
