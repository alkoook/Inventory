<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $orders = Order::with('customer')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.orders.index', [
            'orders' => $orders,
        ])->layout('components.layouts.admin', ['header' => 'الطلبات']);
    }
}
