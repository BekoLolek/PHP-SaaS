<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{

}

trait ApiResponse {
    protected function successResponse($data,int $status = 200): JsonResponse{
        return response()->json([
            'success' => true,
            'data' => $data
        ], $status);
    }

    protected function errorResponse(string $message,int $status = 400, array $errors = []): JsonResponse{
        return response()->json([
            'success' => false,
            'data' => array_merge([
                'message' => $message,
            ], $errors ? ['errors' => $errors] : [])
        ], $status);
    }
}
