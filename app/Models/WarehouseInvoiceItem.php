<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseInvoiceItem extends Model
{
    protected $fillable = [
        'price',
        'arrival_price',
        'product_id',
        'quantity',
        'warehouse_invoice_id',
        'date_expire'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
