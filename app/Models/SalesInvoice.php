<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
<<<<<<< HEAD
        'cost_amount',
        'profit_amount',
        'status',
        'pdf_path',
        'notes',
=======
        'status',
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    ];

    protected $casts = [
        'invoice_date' => 'date',
<<<<<<< HEAD
        'total_amount' => 'decimal:2',
        'cost_amount' => 'decimal:2',
        'profit_amount' => 'decimal:2',
=======
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SalesInvoiceItem::class);
    }
}
