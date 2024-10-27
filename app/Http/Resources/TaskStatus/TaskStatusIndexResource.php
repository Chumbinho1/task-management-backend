<?php

namespace App\Http\Resources\TaskStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskStatusIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'slug' => $this->slug,
            'position' => $this->position,
        ];
    }
}
