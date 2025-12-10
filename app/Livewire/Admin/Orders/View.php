<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Cart;
use App\Models\User;
use Livewire\Component;

class View extends Component
{
    public $cartId;
    public $cart;
    public $workerId;

    public function mount($id)
    {
        $this->cartId = $id;
        $this->cart = Cart::with(['user', 'items.product.category', 'worker'])->findOrFail($id);
        $this->workerId = $this->cart->worker_id;
    }

    public function assignWorker()
    {
        $this->cart->worker_id = $this->workerId;
        $this->cart->save();
        $this->cart->refresh();
        session()->flash('message', 'تم إسناد الطلب للعامل بنجاح.');
    }

    public function render()
    {
        $workers = User::whereHas('roles', function ($q) {
            $q->where('name', 'worker');
        })->get();

        return view('livewire.admin.orders.view', [
            'workers' => $workers,
        ])->layout('components.layouts.admin', ['header' => 'تفاصيل الطلب']);
    }
}
