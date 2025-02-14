<?php

namespace App\Models;

use App\Enums\TrxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'product_id',
        'trx_type',
        'arrival_price',
        'price',
        'quantity',
        'date_expire',
    ];

    protected $casts = [
        'arrival_price' => 'decimal:2',
        'price' => 'decimal:2',
        'trx_type' => TrxType::class,
        'date_expire' => 'datetime',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

}
