<?php

namespace App\Observers;

use App\Models\Cart;
use App\Models\Notification;

class CartObserver
{
    /**
     * Handle the Cart "updated" event.
     */
    public function updated(Cart $cart): void
    {
        // Check if status changed to 'submitted'
        if ($cart->wasChanged('status') && $cart->status === 'submitted') {
            Notification::create([
                'type' => 'new_order',
                'title' => 'طلب جديد',
                'message' => 'تم استلام طلب جديد من ' . ($cart->user->name ?? 'زبون') . ' بقيمة ' . number_format($cart->total_amount, 0) . ' ر.س',
                'cart_id' => $cart->id,
                'is_read' => false,
            ]);
        }
    }
}
