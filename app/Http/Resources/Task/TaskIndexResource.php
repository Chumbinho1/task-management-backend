<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\TaskStatus\TaskStatusIndexResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'taskStatus' => TaskStatusIndexResource::make($this->taskStatus),
            'createdAt' => $this->created_at->format('d/m/Y H:i'),
            'updatedAt' => $this->updated_at->format('d/m/Y H:i'),
        ];
    }
}
