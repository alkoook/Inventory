<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_user_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'cost_amount',
        'profit_amount',
        'status',
        'currency',
        'pdf_path',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'total_amount' => 'decimal:2',
        'cost_amount' => 'decimal:2',
        'profit_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }

    public function items()
    {
        return $this->hasMany(SalesInvoiceItem::class);
    }
}
