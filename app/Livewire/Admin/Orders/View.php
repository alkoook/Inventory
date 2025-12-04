<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use App\Models\InventoryTransaction;
use Livewire\Component;

class View extends Component
{
    public $orderId;
    public $order;

    public function mount($id)
    {
        $this->orderId = $id;
        $this->order = Order::with(['customer', 'items.product'])->findOrFail($id);
    }

    public function approveOrder()
    {
        // Create sales invoice from order
        $invoice = SalesInvoice::create([
            'customer_id' => $this->order->customer_id,
            'invoice_number' => 'INV-' . time(),
            'invoice_date' => now(),
            'total_amount' => $this->order->total_amount,
            'notes' => 'تم إنشاؤها من الطلب #' . $this->order->id,
        ]);

        // Create invoice items and update inventory
        foreach ($this->order->items as $item) {
            SalesInvoiceItem::create([
                'sales_invoice_id' => $invoice->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
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

        // Update order status
        $this->order->update(['status' => 'approved']);

        session()->flash('message', 'تمت الموافقة على الطلب وإنشاء فاتورة المبيعات.');
        return redirect()->route('admin.orders.index');
    }

    public function rejectOrder()
    {
        $this->order->update(['status' => 'rejected']);
        session()->flash('message', 'تم رفض الطلب.');
        return redirect()->route('admin.orders.index');
    }

    public function render()
    {
        return view('livewire.admin.orders.view')
            ->layout('components.layouts.admin', ['header' => 'تفاصيل الطلب']);
    }
}
