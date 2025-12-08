<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Cart;
use Livewire\Component;

class View extends Component
{
    public $cartId;
    public $cart;

    public function mount($id)
    {
        $this->cartId = $id;
        $this->cart = Cart::with(['user', 'items.product.category'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.orders.view')
            ->layout('components.layouts.admin', ['header' => 'تفاصيل الطلب']);
    }
}
