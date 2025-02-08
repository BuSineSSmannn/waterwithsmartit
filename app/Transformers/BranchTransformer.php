<?php

namespace App\Transformers;

use App\Models\Branch;
use League\Fractal\TransformerAbstract;

class BranchTransformer extends TransformerAbstract
{
    /**
     * Преобразовать сущность.
     *
     * @param Branch $model
     * @return array
     */
    public function transform(Branch $model): array
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'address' => $model->address,
            'phone' => $model->phone,
            'created_at' => $model->created_at?->toISOString(),
            'updated_at' => $model->updated_at?->toISOString(),
            'deleted_at' => $model->deleted_at?->toISOString()
        ];
    }


}
