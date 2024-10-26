<?php

namespace App\Services\Task;

use App\Exceptions\NotFoundException;
use App\Models\TaskStatus;

class TaskStatusService
{
    public function __construct(
        protected TaskStatus $taskStatusModel
    ) {}

    public function getTaskStatusBySlug(
        string $slug
    ): TaskStatus {
        $taskStatus = $this->taskStatusModel->where('slug', $slug)->first();

        throw_if(! $taskStatus, NotFoundException::class, 'Task');

        return $taskStatus;
    }
}
