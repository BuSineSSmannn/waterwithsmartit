<?php

namespace App\Transformers\WarehouseInvoice;

use App\Models\WarehouseInvoice;
use League\Fractal\TransformerAbstract;

class WarehouseInvoiceAllTransformer extends TransformerAbstract
{
    public function transform(WarehouseInvoice $stockInvoice): array
    {
        return [
            'id' => (int) $stockInvoice->id,
            'user' => $stockInvoice->user->only('id', 'name'),
            'branch' => $stockInvoice->branch->only('id', 'name'),
            'total_amount' =>  $stockInvoice->total_amount,
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
