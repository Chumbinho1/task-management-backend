<?php

namespace App\Http\Controllers\TaskModule;

use App\Exceptions\NotFoundException;
use App\Filters\TaskModule\Task\TaskIndexFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Resources\Task\TaskIndexResource;
use App\Http\Resources\Task\TaskShowResource;
use App\Services\Task\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    public function index(
        TaskIndexFilters $filters
    ): JsonResponse|AnonymousResourceCollection {
        try {
            return TaskIndexResource::collection($this->taskService->getAll($filters, $filters->getPerPage()));
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }

    public function show(
        string $id
    ): JsonResponse|JsonResource {
        try {
            return ok(TaskShowResource::make($this->taskService->getById($id)));
        } catch (NotFoundException $e) {
            return notFound($e->getMessage());
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }

    public function store(
        TaskStoreRequest $request
    ): JsonResponse {
        try {
            $this->taskService->create($request->validated());

            return created('Task');
        } catch (NotFoundException $e) {
            return notFound($e->getMessage());
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }

    public function update(
        string $id,
        TaskUpdateRequest $request
    ): JsonResponse {
        try {
            $this->taskService->update($id, $request->validated());

            return ok(['message' => 'Task updated successfully!']);
        } catch (NotFoundException $e) {
            return notFound($e->getMessage());
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }

    public function destroy(
        string $id,
    ): JsonResponse {
        try {
            $this->taskService->delete($id);

            return ok(['message' => 'Task deleted successfully!']);
        } catch (NotFoundException $e) {
            return notFound($e->getMessage());
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }
}
