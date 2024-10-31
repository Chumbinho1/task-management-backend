<?php

namespace App\Services\Task;

use App\Exceptions\NotFoundException;
use App\Filters\QueryFilters;
use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function __construct(
        protected Task              $taskModel,
        protected TaskStatusService $taskStatusService
    )
    {
    }

    public function getById(
        string $id
    ): Task
    {
        $task = $this->taskModel->with('taskStatus')->find($id);

        throw_if(!$task, NotFoundException::class, 'Task');

        return $task;
    }

    public function getAll(
        QueryFilters $filters,
        int          $perPage
    ): LengthAwarePaginator
    {
        return $this->taskModel->filter($filters)
            ->with('taskStatus')
            ->paginate($perPage);
    }

    public function create(
        array $data
    ): Task
    {
        return DB::transaction(function () use ($data) {
            $data['user_id'] = auth()->id();
            $data['task_status_id'] = $this->taskStatusService->getTaskStatusBySlug('to-do')->id;

            return $this->taskModel->create(convertKeysToSnakeCase($data));
        });
    }

    public function update(
        string $id,
        array  $data
    ): Task
    {
        return DB::transaction(function () use ($id, $data) {
            $task = $this->getById($id);
            $task->update(convertKeysToSnakeCase($data));

            return $task->fresh();
        });
    }

    public function delete(
        string $id
    ): ?bool
    {
        return DB::transaction(function () use ($id) {
            $task = $this->getById($id);

            return $task->delete();
        });
    }
}
