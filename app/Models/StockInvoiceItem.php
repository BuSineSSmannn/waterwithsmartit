<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInvoiceItem extends Model
{
    protected $fillable = [
        'price',
        'arrival_price',
        'product_id',
        'quantity',
        'stock_invoice_id',
        'date_expire'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
