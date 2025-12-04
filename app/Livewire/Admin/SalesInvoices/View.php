<?php

namespace App\Livewire\Admin\SalesInvoices;

use App\Models\SalesInvoice;
use Livewire\Component;

class View extends Component
{
    public $invoiceId;
    public $invoice;

    public function mount($id)
    {
        $this->invoiceId = $id;
        $this->invoice = SalesInvoice::with(['customer', 'items.product'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.sales-invoices.view')
            ->layout('components.layouts.admin', ['header' => 'عرض الفاتورة']);
    }
}
