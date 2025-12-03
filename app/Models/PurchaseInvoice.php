<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
<<<<<<< HEAD
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
=======
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseInvoiceItem::class);
    }
}
