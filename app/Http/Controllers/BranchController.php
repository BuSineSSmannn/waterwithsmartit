<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;

class BranchController extends ApiController
{
    public function __construct(protected BranchService $service)
    {
    }


    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }


    public function all(): JsonResponse
    {
        return $this->successResponse($this->service->getAll());
    }


    public function show(Branch $branch): JsonResponse
    {
        dd(auth('api')->user()->branches);
        if(!in_array($branch->id, auth('api')->user()->branches->pluck('id')->toArray(), true)){
            return  $this->errorResponse('Forbidden',403);
        }
        return $this->successResponse($this->service->show($branch));
    }

    /**
     * @throws ValidatorException
     */
    public function store(BranchRequest $request): JsonResponse
    {
        if($request->validated()){
            return $this->successResponse($this->service->create($request->validated()), Response::HTTP_CREATED);
        }

        return $this->errorResponse('Validation Failed', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @throws ValidatorException
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        if(!in_array($branch->id, auth('api')->user()->branches->pluck('id')->toArray(), true)){
            return  $this->errorResponse('Forbidden',403);
        }

        if($request->validated()){
            return $this->successResponse( $this->service->update($branch, $request->validated()));
        }

        return $this->errorResponse('Validation Failed', Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function destroy(Branch $branch): JsonResponse
    {
        if(!in_array($branch->id, auth('api')->user()->branches->pluck('id')->toArray(), true)){
            return  $this->errorResponse('Forbidden',403);
        }

        return $this->successResponse((array)$this->service->delete($branch),Response::HTTP_NO_CONTENT);
    }
}
