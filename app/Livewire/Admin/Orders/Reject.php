<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Cart;
use Livewire\Component;

class Reject extends Component
{
    public $cartId;
    public $rejected_reason = '';

    public function mount($id)
    {
        $this->cartId = $id;
    }

    public function reject()
    {
        $this->validate([
            'rejected_reason' => 'required|string|min:3',
        ]);

        $cart = Cart::findOrFail($this->cartId);

        if ($cart->status !== 'submitted') {
            session()->flash('error', 'هذا الطلب غير قابل للرفض');
            return;
        }

        $cart->status = 'rejected';
        $cart->rejected_reason = $this->rejected_reason;
        $cart->approved_by = auth()->id();
        $cart->approved_at = now();
        $cart->save();

        session()->flash('message', 'تم رفض الطلب بنجاح.');
        return redirect()->route('admin.orders.index');
    }

    public function render()
    {
        return view('livewire.admin.orders.reject')
            ->layout('components.layouts.admin', ['header' => 'رفض الطلب']);
    }
}
