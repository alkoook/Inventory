<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

<<<<<<< HEAD
    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

=======
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
<<<<<<< HEAD
        return $this->belongsTo(\App\Models\Product::class);
=======
        return $this->belongsTo(Product::class);
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }
}
