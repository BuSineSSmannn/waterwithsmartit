<?php

namespace App\Models;

use App\Enums\MovementProductType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseMovement extends Model
{

    protected $table = 'warehouse_movements';

    protected $casts = [
        'type' => MovementProductType::class
    ];

    protected $fillable = [
        'branch_id',
        'warehouse_id',
        'user_id',
        'type',
        'quantity',
        'description',
        'invoice_id',
        'purchase_price',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(WarehouseInvoice::class);
    }
}
