<?php

namespace App\Filters\TaskModule\Task;

use App\Filters\QueryFilters;
use App\Http\Requests\Task\TaskIndexFiltersRequest;
use Illuminate\Database\Eloquent\Builder;

class TaskIndexFilters extends QueryFilters
{
    public function __construct(
        TaskIndexFiltersRequest $request
    ) {
        parent::__construct($request);
    }

    public function title(
        string $title
    ): Builder {
        return $this->builder->where('title', 'like', "%$title%");
    }

    public function description(
        string $description
    ): Builder {
        return $this->builder->where('description', 'like', "%$description%");
    }

    public function taskStatusId(
        string $taskStatusId
    ): Builder {
        return $this->builder->where('task_status_id', $taskStatusId);
    }

    public function orderBy(
        array $orderBy
    ): Builder {
        match ($orderBy['field']) {
            'title' => $this->builder->orderBy('title', $orderBy['order']),
            'description' => $this->builder->orderBy('description', $orderBy['order']),
            'taskStatus' => $this->builder->join('task_statuses', 'tasks.task_status_id', '=', 'task_statuses.id')->orderBy('task_statuses.description', $orderBy['order']),
            default => $this->builder->orderBy('created_at', 'desc'),
        };

        return $this->builder->orderBy('created_at', 'desc');
    }
}
