<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $product): array
    {
        return [
            'id' => (int) $product->id,
            'name' => $product->name,
            'mxik_code' => $product->mxik_code,
            'mxik_name' => $product->mxik_name,
            'barcode' => $product->barcode,
            'measuring_group' => $product->measuring_group,
            'unit' => $product->unit,
            'product_group' => $product->productGroup,
            'product_classification' => $product->productClassification,
            'product_position' => $product->productPosition,
            'product_supposition' => $product->productSupposition,
            'product_brand' => $product->productBrand,
            'packaging' => $product->packaging,
            'price' => $product->price,
            'status' => $product->status,
            'full_name' => $product->productSupposition->name . ':' .  $product->productBrand->name,
            'is_imported' => (bool) $product->is_imported,
            'created_at' => $product->created_at?->toISOString(),
            'updated_at' => $product->updated_at?->toISOString(),
            'deleted_at' => $product->deleted_at?->toISOString(),

        ];
    }

}
