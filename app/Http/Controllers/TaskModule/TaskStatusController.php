<?php

namespace App\Http\Controllers\TaskModule;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskStatus\TaskStatusIndexResource;
use App\Services\Task\TaskStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskStatusController extends Controller
{
    public function __construct(
        protected TaskStatusService $taskStatusService
    ) {}

    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            return TaskStatusIndexResource::collection($this->taskStatusService->getAll());
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }
}
