<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Cart;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Approve extends Component
{
    public $cartId;

    public function mount($id)
    {
        $this->cartId = $id;
    }

    public function approve()
    {
        DB::transaction(function () {
            $cart = Cart::with(['user', 'items.product'])->findOrFail($this->cartId);

            if ($cart->status !== 'submitted') {
                session()->flash('error', 'هذا الطلب غير قابل للموافقة');
                return;
            }

            // Create sales invoice
            $invoice = SalesInvoice::create([
                'user_id' => auth()->id(),
                'customer_user_id' => $cart->user_id,
                'invoice_number' => 'SINV-' . now()->format('YmdHis') . '-' . $cart->id,
                'invoice_date' => now(),
                'total_amount' => $cart->total_amount,
                'cost_amount' => $cart->items->sum(function ($item) {
                    return $item->quantity * $item->product->purchase_price;
                }),
                'profit_amount' => $cart->total_amount - $cart->items->sum(function ($item) {
                    return $item->quantity * $item->product->purchase_price;
                }),
                'status' => 'approved',
                'notes' => 'تم إنشاؤها من الطلب #' . $cart->id,
            ]);

            // Create invoice items and update inventory
            foreach ($cart->items as $item) {
                SalesInvoiceItem::create([
                    'sales_invoice_id' => $invoice->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_of_measure' => $item->product->unit_of_measure ?? 'قطعة',
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);

                // Update inventory
                InventoryTransaction::createTransaction(
                    $item->product_id,
                    'sale',
                    $item->quantity,
                    'App\Models\SalesInvoice',
                    $invoice->id,
                    'بيع من فاتورة: ' . $invoice->invoice_number
                );
            }

            // Update cart status
            $cart->status = 'approved';
            $cart->approved_by = auth()->id();
            $cart->approved_at = now();
            $cart->save();
        });

        session()->flash('message', 'تمت الموافقة على الطلب وإنشاء فاتورة المبيعات بنجاح.');
        return redirect()->route('admin.orders.index');
    }

    public function render()
    {
        return view('livewire.admin.orders.approve')
            ->layout('components.layouts.admin', ['header' => 'موافقة على الطلب']);
    }
}
