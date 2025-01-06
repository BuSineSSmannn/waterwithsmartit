<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceEnum;
use App\Http\Requests\StockInvoiceRequest;
use App\Models\StockInvoice;
use App\Services\StockInvoiceService;
use RuntimeException;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;

class StockInvoiceController extends ApiController
{

    public function __construct(readonly protected StockInvoiceService $service)
    {
    }


    public function show(StockInvoice $stockInvoice): JsonResponse
    {
        return $this->successResponse($this->service->show($stockInvoice));
    }

    /**
     * @throws ValidatorException
     */
    public function store(StockInvoiceRequest $request): JsonResponse
    {
        return $this->successResponse($this->service->create($request->validated()));
    }

    public function update(StockInvoice $stock_invoice, StockInvoiceRequest $request): JsonResponse
    {
        if($stock_invoice->status !== InvoiceEnum::DRAFT){
            throw new RuntimeException('Invoice cannot be updated');
        }
        return $this->successResponse($this->service->update($stock_invoice,$request->validated()));

    }
}
