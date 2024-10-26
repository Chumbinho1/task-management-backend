<?php

namespace App\Services\Task;

use App\Models\Task;

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
        $data['user_id'] = auth()->id();
        $data['task_status_id'] = $this->taskStatusService->getTaskStatusBySlug('to-do')->id;

        return $this->taskModel->create(convertKeysToSnakeCase($data));
    }
}
