<?php

namespace App\Livewire\Admin\Workers;

use App\Models\SalesInvoice;
use Livewire\Component;

class InvoiceView extends Component
{
    public $invoiceId;
    public $invoice;

    public function mount($id)
    {
        $this->invoiceId = $id;
        $this->invoice = SalesInvoice::with(['customer', 'items.product'])
            ->where('worker_id', auth()->id())
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.workers.invoice-view')
            ->layout('components.layouts.admin', ['header' => 'عرض الفاتورة']);
    }
}
