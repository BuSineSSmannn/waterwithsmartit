<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Models\Color;
use App\Services\ColorService;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;

class ColorController extends ApiController
{
    public function __construct(protected ColorService $service)
    {
    }


    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }


    public function show(Color $color): JsonResponse
    {
        return $this->successResponse($this->service->show($color));
    }


    /**
     * @throws ValidatorException
     */
    public function store(ColorRequest $request): JsonResponse
    {
        if($request->validated()){
            return $this->successResponse($this->service->create($request->validated()), Response::HTTP_CREATED);
        }

        return $this->errorResponse('Validation Failed', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @throws ValidatorException
     */
    public function update(ColorRequest $request, Color $color)
    {

        if($request->validated()){
            return $this->successResponse( $this->service->update($color, $request->validated()));
        }


        return $this->errorResponse('Validation Failed', Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function destroy(Color $color): JsonResponse
    {
        return $this->successResponse((array)$this->service->delete($color));
    }
}
