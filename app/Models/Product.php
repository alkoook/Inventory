<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'company_id',
        'name',
        'sku',
        'description',
        'purchase_price',
        'sale_price',
        'stock',
        'reorder_level',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * Get current stock from inventory transactions
     */
    public function getCurrentStock()
    {
        return $this->inventoryTransactions()
            ->selectRaw('
                SUM(CASE 
                    WHEN transaction_type IN ("purchase", "return_sale", "adjustment") THEN quantity
                    WHEN transaction_type IN ("sale", "return_purchase") THEN -quantity
                    ELSE 0
                END) as total_stock
            ')
            ->value('total_stock') ?? 0;
    }
}
