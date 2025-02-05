<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\StockService;
use Illuminate\Http\JsonResponse;

class StockController extends ApiController
{

    public function __construct(readonly protected StockService $service)
    {
    }

    public function index(): JsonResponse
    {
       return $this->successResponse($this->service->all());
    }

    public function show(Stock $stock): JsonResponse
    {
        return $this->successResponse($this->service->show($stock));
    }
}
