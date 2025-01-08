<?php

namespace App\Transformers\StockInvoice;

use App\Models\StockInvoice;
use App\Transformers\ProductTransformer;
use League\Fractal\TransformerAbstract;

class StockInvoiceAllTransformer extends TransformerAbstract
{
    public function transform(StockInvoice $stockInvoice): array
    {
        return [
            'id' => (int) $stockInvoice->id,
            'user' => $stockInvoice->user->only('id', 'name'),
            'supplier' => $stockInvoice->supplier->only('id', 'name','phone_number'),
            'total_amount' =>  $stockInvoice->total_amount,
            'trx_type' => [
                'name' => $stockInvoice->trx_type,
                'translate' => $stockInvoice->trx_type->translate()
            ],
            'status' => [
                'name' => $stockInvoice->status,
                'translate' => $stockInvoice->status->translate()
            ],

            'created_at' => $stockInvoice->created_at?->toISOString(),
            'updated_at' => $stockInvoice->updated_at?->toISOString(),
            'deleted_at' => $stockInvoice->deleted_at?->toISOString(),

        ];
    }

}
