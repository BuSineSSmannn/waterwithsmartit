<?php

namespace App\Models;

use App\Enums\InvoiceEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Random\RandomException;

class WarehouseInvoice extends Model
{
    use SoftDeletes;

    protected $table = 'warehouse_invoices';


    protected $fillable = [
        'branch_id',
        'user_id',
        'total_amount',
        'comment',
        'status',
        'code'
    ];

    protected $casts = [
        'status' => InvoiceEnum::class,
        'total_amount' => 'decimal:2',
    ];


    protected static function booted(): void
    {
        parent::booted();

        static::creating(static function ($invoice) {
            $invoice->code = $invoice->generateUniqueNumericCode();
        });
    }


    /**
     * @throws RandomException
     */
    public function generateUniqueNumericCode(): string
    {
        do {
            $code = str_pad(random_int(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function items(): HasMany
    {
        return $this->hasMany(WarehouseInvoiceItem::class, 'warehouse_invoice_id', 'id');
    }


    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    //
}
