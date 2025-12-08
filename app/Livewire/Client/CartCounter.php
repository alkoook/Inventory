<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class CartCounter extends Component
{
    public $itemCount = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('cart-updated')]
    public function updateCount()
    {
        $user = Auth::user();
        
        if (!$user || !$user->hasRole('customer')) {
            $this->itemCount = 0;
            return;
        }

        $cart = Cart::where('user_id', $user->id)
            ->where('status', 'open')
            ->first();

        $this->itemCount = $cart ? $cart->items()->sum('quantity') : 0;
    }

    public function render()
    {
        return view('livewire.client.cart-counter')->layout('components.layouts.app');
    }
}
