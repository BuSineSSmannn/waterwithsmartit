<?php

namespace App\Http\Controllers;

use App\Http\Requests\SizeRequest;
use App\Models\Size;
use App\Services\SizeService;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;

class SizeController extends ApiController
{

    public function __construct(protected SizeService $service)
    {
    }

    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }

    public function show(Size $size): JsonResponse
    {
        return $this->successResponse($this->service->show($size));
    }


    /**
     * @throws ValidatorException
     */
    public function store(SizeRequest $request): JsonResponse
    {
        if($request->validated()){
            return $this->successResponse($this->service->create($request->validated() ), Response::HTTP_CREATED);
        }

        return $this->errorResponse('Validation Failed', Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function destroy(Size $size): JsonResponse
    {
        return $this->successResponse((array)$this->service->delete($size));
    }


}
