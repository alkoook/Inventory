<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_invoice_id',
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

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
=======
    public function invoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
