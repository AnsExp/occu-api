<?php

namespace App\Http\Responses;

use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{
    public static function pagination(LengthAwarePaginator $paginator, bool $success = true, ?string $message = null, int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message ?? ($success ? 'Results retrieved successfully' : 'No results found'),
            'data' => $paginator->items(),
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'from' => $paginator->firstItem(),
                'last_page' => $paginator->lastPage(),
                'links' => $paginator->linkCollection(),
                'path' => $paginator->path(),
                'per_page' => $paginator->perPage(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
            ],
        ], $status, $headers, $options);
    }

    public static function data($data, bool $success = true, ?string $message = null, int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message ?? ($success ? 'Operation successful' : 'Operation failed'),
            'data' => $data,
        ], $status, $headers, $options);
    }

    public static function formResponse(array $errors, bool $success = false, ?string $message = null, int $status = 400, array $headers = [], int $options = 0): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message ?? ($success ? 'Operation successful' : 'Operation failed'),
            'errors' => $errors,
            'data' => null,
        ], $status, $headers, $options);
    }
}
