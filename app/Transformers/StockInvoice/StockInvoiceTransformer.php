<?php

namespace App\Transformers\StockInvoice;

use App\Models\StockInvoice;
use App\Transformers\ProductTransformer;
use League\Fractal\TransformerAbstract;

class StockInvoiceTransformer extends TransformerAbstract
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
            'items' => $stockInvoice->items->map(function ($item) {

                return [
                    'id' => (int) $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'arrival_price' => $item->arrival_price,
                    'date_expire' => $item->date_expire,
                    'product' => [

                        'id' => (int) $item->product->id,
                        'name' => $item->product->name,
                        'mxik_code' => $item->product->mxik_code,
                        'mxik_name' => $item->product->mxik_name,
                        'barcode' => $item->product->barcode,
                        'full_name' =>  $item->product->productSupposition->name . ':' .   $item->product->productBrand->name . ', ' .  $item->product->measuring_group,

                    ],
                ];
            })->values()->all(),

            'created_at' => $stockInvoice->created_at?->toISOString(),
            'updated_at' => $stockInvoice->updated_at?->toISOString(),
            'deleted_at' => $stockInvoice->deleted_at?->toISOString(),

        ];
    }

}
