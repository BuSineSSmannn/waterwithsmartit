<?php

namespace App\Transformers;

use App\Models\StockInvoice;
use League\Fractal\TransformerAbstract;

class StockInvoiceTransformer extends TransformerAbstract
{
    public function transform(StockInvoice $stockInvoice): array
    {
        return [
            'id' => (int) $stockInvoice->id,
            'user' => $stockInvoice->user->only('id', 'name'),
            'supplier' => $stockInvoice->supplier->only('id', 'name','phone_number'),
            'created_at' => $stockInvoice->created_at?->toISOString(),
            'updated_at' => $stockInvoice->updated_at?->toISOString(),
            'deleted_at' => $stockInvoice->deleted_at?->toISOString(),

        ];
    }

}
