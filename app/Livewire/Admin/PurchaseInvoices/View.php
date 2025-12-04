<?php

namespace App\Livewire\Admin\PurchaseInvoices;

use App\Models\PurchaseInvoice;
use Livewire\Component;

class View extends Component
{
    public $invoiceId;
    public $invoice;

    public function mount($id)
    {
        $this->invoiceId = $id;
        $this->invoice = PurchaseInvoice::with(['company', 'items.product'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.purchase-invoices.view')
            ->layout('components.layouts.admin', ['header' => 'عرض الفاتورة']);
    }
}
