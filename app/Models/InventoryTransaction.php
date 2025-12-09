<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'transaction_type',
        'quantity',
        'reference_type',
        'reference_id',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic relationship to reference (invoice, order, etc.)
    public function reference()
    {
        return $this->morphTo();
    }

    /**
     * Create inventory transaction and update product stock
     */
    public static function createTransaction(
        int $productId,
        string $transactionType,
        int $quantity,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $notes = null,
        ?int $userId = null
    ) {
        // Get product and check stock availability for sales
        $product = Product::find($productId);
        if (!$product) {
            throw new \Exception("المنتج غير موجود");
        }

        // Check stock availability before creating sale transaction
        if (in_array($transactionType, ['sale', 'return_purchase'])) {
            $currentStock = $product->stock;
            if ($currentStock < abs($quantity)) {
                throw new \Exception("المخزون غير كافٍ. المخزون المتاح: {$currentStock}، المطلوب: " . abs($quantity));
            }
        }

        $transaction = self::create([
            'product_id' => $productId,
            'transaction_type' => $transactionType,
            'quantity' => $quantity,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'notes' => $notes,
            'user_id' => $userId ?? auth()->id(),
        ]);

        // Update product stock
        if ($product) {
            $oldStock = $product->stock;
            
            // For purchases and returns of sales, increase stock
            if (in_array($transactionType, ['purchase', 'return_sale', 'adjustment'])) {
                $product->increment('stock', abs($quantity));
            }
            // For sales and returns of purchases, decrease stock
            elseif (in_array($transactionType, ['sale', 'return_purchase'])) {
                $product->decrement('stock', abs($quantity));
            }

            // Refresh product to get updated stock
            $product->refresh();

            // Check if stock is low or out of stock and create notification
            self::checkStockLevels($product, $oldStock);
        }

        return $transaction;
    }

    /**
     * Check stock levels and create notifications if needed
     */
    protected static function checkStockLevels(Product $product, int $oldStock): void
    {
        $currentStock = $product->stock;
        $reorderLevel = $product->reorder_level ?? 0;

        // Check if product just went below reorder level or out of stock
        if ($currentStock <= 0) {
            // Out of stock
            // Check if there's already ANY notification (read or unread) for this product being out of stock
            $existingNotification = \App\Models\Notification::where('product_id', $product->id)
                ->where('type', 'out_of_stock')
                ->latest()
                ->first();

            if (!$existingNotification) {
                \App\Models\Notification::create([
                    'type' => 'out_of_stock',
                    'title' => 'نفذ المخزون',
                    'message' => "المنتج '{$product->name}' (SKU: {$product->sku}) نفذ من المخزون. المخزون الحالي: {$currentStock}",
                    'product_id' => $product->id,
                ]);
            }
        } elseif ($currentStock <= $reorderLevel && $reorderLevel > 0) {
            // Low stock (below reorder level)
            // Only create notification if it wasn't already below reorder level
            if ($oldStock > $reorderLevel) {
                // Check if there's already ANY notification (read or unread) for this product being low stock
                $existingNotification = \App\Models\Notification::where('product_id', $product->id)
                    ->where('type', 'low_stock')
                    ->latest()
                    ->first();

                if (!$existingNotification) {
                    \App\Models\Notification::create([
                        'type' => 'low_stock',
                        'title' => 'مخزون منخفض',
                        'message' => "المنتج '{$product->name}' (SKU: {$product->sku}) وصل إلى الحد الأدنى. المخزون الحالي: {$currentStock}، الحد الأدنى: {$reorderLevel}",
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
    }
}
