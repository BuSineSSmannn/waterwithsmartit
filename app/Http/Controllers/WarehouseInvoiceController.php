<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceEnum;
use App\Http\Requests\WarehouseInvoiceRequest;
use App\Models\WarehouseInvoice;
use App\Services\WarehouseInvoiceService;
use RuntimeException;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;

class WarehouseInvoiceController extends ApiController
{
    public function __construct(readonly protected WarehouseInvoiceService $service)
    {
    }

    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }

    public function show(WarehouseInvoice $warehouseInvoice): JsonResponse
    {
        return $this->successResponse($this->service->show($warehouseInvoice));
    }

    /**
     * @throws ValidatorException
     */
    public function store(WarehouseInvoiceRequest $request): JsonResponse
    {
        return $this->successResponse($this->service->create($request->validated()));
    }

    public function reject(WarehouseInvoice $warehouseInvoice): JsonResponse
    {
        if($warehouseInvoice->status !== InvoiceEnum::DRAFT){
            throw new RuntimeException('Invoice cannot be rejected');
        }

        return $this->successResponse($this->service->reject($warehouseInvoice));
    }

    public function confirm(WarehouseInvoice $warehouseInvoice): JsonResponse
    {
        if($warehouseInvoice->status !== InvoiceEnum::DRAFT){
            throw new RuntimeException('Invoice cannot be confirmed');
        }
        return $this->successResponse($this->service->confirm($warehouseInvoice));
    }

    public function update(WarehouseInvoice $warehouseInvoice, WarehouseInvoiceRequest $request): JsonResponse
    {
        if($warehouseInvoice->status !== InvoiceEnum::DRAFT){
            throw new RuntimeException('Invoice cannot be updated');
        }
        return $this->successResponse($this->service->update($warehouseInvoice,$request->validated()));

    }
}
