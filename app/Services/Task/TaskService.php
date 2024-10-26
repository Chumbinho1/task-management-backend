<?php

namespace App\Services\Task;

use App\Exceptions\NotFoundException;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function __construct(
        protected Task              $taskModel,
        protected TaskStatusService $taskStatusService
    )
    {
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
            $task = $this->getTaskById($id);
            $task->update(convertKeysToSnakeCase($data));

            return $task->fresh();
        });
    }

    public function getTaskById(string $id): Task {
        $task = $this->taskModel->find($id);

        throw_if(!$task, NotFoundException::class, 'Task');

        return $task;
    }
}
