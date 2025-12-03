<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
<<<<<<< HEAD
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'category_id',
        'company_id',
=======
    use HasFactory;

    protected $fillable = [
        'category_id',
        'company_id',
        'name',
        'sku',
        'description',
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
        'purchase_price',
        'sale_price',
        'stock',
        'reorder_level',
        'is_active',
    ];

<<<<<<< HEAD
    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category()
    {
=======
    public function category(){
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
        return $this->belongsTo(Category::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
