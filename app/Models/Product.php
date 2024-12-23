<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'product_group_id',
        'product_classification_id',
        'product_position_id',
        'product_supposition_id',
        'product_brand_id',
        'name',
        'mxik_code',
        'mxik_name',
        'barcode',
        'measuring_group',
        'unit',
        'packaging',
        'status',
        'is_imported',
    ];

    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function productClassification(): BelongsTo
    {
        return $this->belongsTo(ProductClassification::class);
    }

    public function productPosition(): BelongsTo
    {
        return $this->belongsTo(ProductPosition::class);
    }

    public function productSupposition(): BelongsTo
    {
        return $this->belongsTo(ProductSupposition::class);
    }

    public function productBrand(): BelongsTo
    {
        return $this->belongsTo(ProductBrand::class);
    }



}
