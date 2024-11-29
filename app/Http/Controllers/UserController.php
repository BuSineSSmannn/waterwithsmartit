<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{
    protected UserService $service ;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }


    public function show(User $user): JsonResponse
    {
        return $this->successResponse($this->service->show($user));
    }
}
