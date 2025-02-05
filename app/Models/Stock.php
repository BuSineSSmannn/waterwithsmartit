<?php

namespace App\Models;

use App\Enums\TrxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

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


    protected $casts = [
        'trx_type' => TrxType::class,
        'date_expire' => 'datetime',
    ];


    public function product(): belongsTo
    {
       return $this->belongsTo(Product::class);
    }
}
