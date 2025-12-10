<?php

namespace App\Livewire\Admin\Workers;

use App\Models\SalesInvoice;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // عرض الفواتير التي تم الموافقة عليها من الطلبات (cart_id موجود)
        $invoices = SalesInvoice::with(['user', 'customer', 'worker', 'cart'])
            ->whereNotNull('cart_id')
            ->where('status', 'approved')
            ->when($this->search, function ($query) {
                $query->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest()
            ->paginate(10);

        // جلب العاملين
        $workers = User::whereHas('roles', function ($q) {
            $q->where('name', 'worker');
        })->get();

        return view('livewire.admin.workers.index', [
            'invoices' => $invoices,
            'workers' => $workers,
        ])->layout('components.layouts.admin', ['header' => 'العاملين']);
    }

    public function assignWorker($invoiceId, $workerId)
    {
        $invoice = SalesInvoice::findOrFail($invoiceId);
        $invoice->worker_id = $workerId;
        $invoice->save();

        session()->flash('message', 'تم إسناد الفاتورة للعامل بنجاح.');
    }
}
