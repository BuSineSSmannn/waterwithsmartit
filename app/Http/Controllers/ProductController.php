<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends ApiController
{
    public function __construct(protected ProductService $service)
    {
    }

    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }


    public function show(Product $product): JsonResponse
    {
        return $this->successResponse($this->service->show($product));
    }

}
