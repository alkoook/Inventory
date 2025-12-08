<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $orders = Cart::with(['user', 'items.product'])
            ->where('status', 'submitted')
            ->latest('submitted_at')
            ->paginate(10);

        return view('livewire.admin.orders.index', [
            'orders' => $orders,
        ])->layout('components.layouts.admin', ['header' => 'الطلبات']);
    }
}
