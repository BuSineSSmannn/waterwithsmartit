<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends ApiController
{


    public function __construct(readonly protected CategoryService $service ){}

    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }

    public function show(Category $category): JsonResponse
    {
        return $this->successResponse($this->service->show($category));
    }

    /**
     * @throws ValidatorException
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        if($request->validated()){
            return $this->successResponse($this->service->create($request->validated()), Response::HTTP_CREATED);
        }

        return $this->errorResponse('Invalid data', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @throws ValidatorException
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        if($request->validated()){
            return $this->successResponse($this->service->update($category,$request->validated()));
        }

        return $this->errorResponse('Invalid data', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function destroy(Category $category): JsonResponse
    {
        if($this->service->delete($category)){
            return $this->successResponse([],Response::HTTP_NO_CONTENT);
        }

        return $this->errorResponse('No deleting',500);

    }


}
