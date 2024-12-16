<?php

namespace App\Transformers;

use App\Models\Size;
use League\Fractal\TransformerAbstract;

class SizeTransformer extends TransformerAbstract
{
    /**
     * Преобразовать сущность.
     *
     * @param Size $model
     * @return array
     */
    public function transform(Size $model): array
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'category' => $model->category,
        ];
    }


}
