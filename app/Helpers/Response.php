<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

function created(string $message = 'Resource created!'): JsonResponse
{
    return response()->json([
        'message' => $message
    ], Response::HTTP_CREATED);
}

function internalServerError(string $message = 'Something went wrong!'): JsonResponse
{
    return response()->json([
        'message' => $message
    ], Response::HTTP_INTERNAL_SERVER_ERROR);
}
