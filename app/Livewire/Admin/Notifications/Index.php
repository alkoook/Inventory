<?php

namespace App\Livewire\Admin\Notifications;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $filter = 'all'; // all, unread, read

    public function markAsRead($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        $notification->markAsRead();
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        session()->flash('message', 'تم تحديد جميع الإشعارات كمقروءة.');
    }

    public function delete($notificationId)
    {
        Notification::findOrFail($notificationId)->delete();
        session()->flash('message', 'تم حذف الإشعار.');
    }

    public function mount()
    {
        // Check all products for low stock when page loads
        $this->checkAllProducts();
    }

    protected function checkAllProducts()
    {
        $products = \App\Models\Product::where('is_active', true)->get();

        foreach ($products as $product) {
            $currentStock = $product->stock;
            $reorderLevel = $product->reorder_level ?? 0;

            if ($currentStock <= 0 && $reorderLevel >= 0) {
                // Out of stock - check if ANY notification exists (read or unread) for this product
                $existingNotification = Notification::where('product_id', $product->id)
                    ->where('type', 'out_of_stock')
                    ->latest()
                    ->first();

                if (!$existingNotification) {
                    Notification::create([
                        'type' => 'out_of_stock',
                        'title' => 'نفذ المخزون',
                        'message' => "المنتج '{$product->name}' (SKU: {$product->sku}) نفذ من المخزون. المخزون الحالي: {$currentStock}",
                        'product_id' => $product->id,
                    ]);
                }
            } elseif ($currentStock <= $reorderLevel && $reorderLevel > 0) {
                // Low stock - check if ANY notification exists (read or unread) for this product
                $existingNotification = Notification::where('product_id', $product->id)
                    ->where('type', 'low_stock')
                    ->latest()
                    ->first();

                if (!$existingNotification) {
                    Notification::create([
                        'type' => 'low_stock',
                        'title' => 'مخزون منخفض',
                        'message' => "المنتج '{$product->name}' (SKU: {$product->sku}) وصل إلى الحد الأدنى. المخزون الحالي: {$currentStock}، الحد الأدنى: {$reorderLevel}",
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
    }

    public function render()
    {
        $query = Notification::with('product')
            ->orderBy('created_at', 'desc');

        if ($this->filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($this->filter === 'read') {
            $query->where('is_read', true);
        }

        $notifications = $query->paginate(20);

        return view('livewire.admin.notifications.index', [
            'notifications' => $notifications,
            'unreadCount' => Notification::unreadCount(),
        ])->layout('components.layouts.admin', ['header' => 'الإشعارات']);
    }
}

