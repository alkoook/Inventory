<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    protected $fillable = [
<<<<<<< HEAD
        'user_id',
        'session_id',
        'total_amount',
        'status',
        'submitted_at',
        'approved_by',
        'approved_at',
        'rejected_reason',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
=======
        'customer_id',
        'status',
        'total_amount',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
<<<<<<< HEAD

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
=======
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
}
