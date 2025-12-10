<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CartObserver;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'status',
        'total_amount',
        'submitted_at',
        'approved_by',
        'approved_at',
        'rejected_reason',
        'worker_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::observe(CartObserver::class);
    }
}
