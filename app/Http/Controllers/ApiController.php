<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    protected function jsonResponse(mixed $data, int $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }

    protected function errorResponse($message, $status, $errors = []): JsonResponse
    {
        $response = ['error' => $message];
        if (!empty($errors)) {
            $response = array_merge($response, $errors);
        }
        return response()->json($response, $status);
    }
}
