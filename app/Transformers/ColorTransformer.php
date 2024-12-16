<?php

namespace App\Transformers;

use App\Models\Color;
use League\Fractal\TransformerAbstract;

class ColorTransformer extends TransformerAbstract
{
    /**
     * Преобразовать сущность.
     *
     * @param Color $model
     * @return array
     */
    public function transform(Color $model): array
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
        ];
    }


}
