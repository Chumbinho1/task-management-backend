<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

function ok(mixed $data): JsonResponse
{
    return response()->json($data, Response::HTTP_OK);
}

function created(string $message = 'Resource created!'): JsonResponse
{
    return response()->json([
        'message' => $message,
    ], Response::HTTP_CREATED);
}

function internalServerError(string $message = 'Something went wrong!'): JsonResponse
{
    return response()->json([
        'message' => $message,
    ], Response::HTTP_INTERNAL_SERVER_ERROR);
}

function unauthorized(string $message = 'Unauthorized!'): JsonResponse
{
    return response()->json([
        'message' => $message,
    ], Response::HTTP_UNAUTHORIZED);
}
