<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponserTrait
{

    protected function successResponse($data, string $message = null, int $httpResponseCode = 200): JsonResponse
    {
        return response()->json([
            'success'    => true,
            'message'    => $message,
            'data'       => $data,
        ], $httpResponseCode);
    }

    protected function errorResponse(string $message, int $httpResponseCode = 400): JsonResponse
    {
        return response()->json([
            'success'    => false,
            'message'    => $message ?? null,
            'data'       => null,
        ], $httpResponseCode);
    }
}
