<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\JsonResponse;

class PermissionController extends ApiController
{
    public function index(): JsonResponse
    {
        return $this->successResponse([
            'permissions' => Permission::all()
        ]);
    }
}
