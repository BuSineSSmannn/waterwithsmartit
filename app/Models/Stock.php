<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $fillable = [
        'product_id',
        'quantity',
        'date_expire',
        'price',
        'arrival_price',
        'trx_type',
    ];
}
