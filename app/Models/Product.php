<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

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

    public function category(){
        return $this->belongsTo(Category::class);
    }
      public function Company(){
        return $this->belongsTo(Company::class);
    }
}
