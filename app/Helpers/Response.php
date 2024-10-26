<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

function ok(JsonResource|AnonymousResourceCollection|array $data): JsonResponse
{
    return response()->json($data, Response::HTTP_OK);
}

function created(?string $item = null): JsonResponse
{
    return response()->json([
        'message' => $item ? `${$item} created successfully!` : 'Created successfully!',
    ], Response::HTTP_CREATED);
}

function internalServerError(\Exception $exception): JsonResponse
{
    Log::error($exception->getMessage(), $exception->getTrace());

    return response()->json([
        'message' => 'Internal server error!',
    ], Response::HTTP_INTERNAL_SERVER_ERROR);
}

function unauthorized(string $message = 'Unauthorized!'): JsonResponse
{
    return response()->json([
        'message' => $message,
    ], Response::HTTP_UNAUTHORIZED);
}
