<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Random\RandomException;

class StockInvoice extends Model
{

    use SoftDeletes;

    protected $table = 'stock_invoices';

    protected $fillable = [
        'supplier_id',
        'user_id',
        'total_amount',
        'comment',
        'status',
        'transaction_type',
        'code'
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

    public function stockInvoiceItems(): HasMany
    {
        return $this->hasMany(StockInvoiceItem::class, 'stock_invoice_id', 'id');
    }


    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
