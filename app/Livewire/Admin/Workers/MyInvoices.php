<?php

namespace App\Livewire\Admin\Workers;

use App\Models\SalesInvoice;
use Livewire\Component;
use Livewire\WithPagination;

class MyInvoices extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // عرض الفواتير المسندة للعامل الحالي
        $invoices = SalesInvoice::with(['customer', 'cart'])
            ->where('worker_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.workers.my-invoices', [
            'invoices' => $invoices,
        ])->layout('components.layouts.admin', ['header' => 'فواتيري']);
    }
}
