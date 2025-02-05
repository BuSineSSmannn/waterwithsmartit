<?php

namespace App\Transformers;

use App\Models\Stock;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class StockTransformer extends TransformerAbstract
{
    /**
     * Преобразовать сущность.
     *
     * @param Stock $model
     * @return array
     */
    public function transform(Stock $model): array
    {
        return [
            'id' => (int) $model->id,
            'product' => [
                'id' => $model->product->id,
                'name' => $model->product->name,
                'mxik_code' => $model->product->mxik_code,
                'mxik_name' => $model->product->mxik_name,
                'barcode' => $model->product->barcode,
                'full_name' => $model->product->productSupposition->name . ':' .  $model->product->productBrand->name . ', ' . $model->product->measuring_group,
            ],
            'arrival_price' => $model->arrival_price,
            'price' => $model->price,
            'quantity' => $model->quantity,
            'trx_type' => [
                'name' => $model->trx_type->name,
                'translate' => $model->trx_type->translate(),
            ],
            'date_expire' => $model->date_expire->format('d.m.Y'),
            'expire_day' => Carbon::now()->diffInDays($model->date_expire),
        ];
    }


}
