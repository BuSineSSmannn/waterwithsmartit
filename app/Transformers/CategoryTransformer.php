<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Category;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * Преобразовать сущность Category.
     *
     * @param Category $model
     * @return array
     */
    public function transform(Category $model): array
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'slug' => $model->slug,
            'description' => $model->description
        ];
    }


}
