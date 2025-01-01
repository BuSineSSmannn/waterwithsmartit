<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockInvoiceRequest;
use App\Services\StockInvoiceService;
use Illuminate\Http\Request;

class StockInvoiceController extends ApiController
{

    public function __construct(readonly protected StockInvoiceService $service)
    {
    }


    public function store(StockInvoiceRequest $request){
        return $this->successResponse($this->service->create($request->validated()));
    }
}
