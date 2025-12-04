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
        $product = Product::find($productId);
        if ($product) {
            // For purchases and returns of sales, increase stock
            if (in_array($transactionType, ['purchase', 'return_sale', 'adjustment'])) {
                $product->increment('stock', abs($quantity));
            }
            // For sales and returns of purchases, decrease stock
            elseif (in_array($transactionType, ['sale', 'return_purchase'])) {
                $product->decrement('stock', abs($quantity));
            }
        }

        return $transaction;
    }
}
