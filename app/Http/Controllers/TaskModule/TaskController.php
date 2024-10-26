<?php

namespace App\Http\Controllers\TaskModule;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Services\Task\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    )
    {
    }

    public function store(
        TaskStoreRequest $request
    ): JsonResponse
    {
        try {
            $this->taskService->create($request->validated());

            return created('Task');
        } catch (NotFoundException $e) {
            return notFound($e->getMessage());
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }
}
