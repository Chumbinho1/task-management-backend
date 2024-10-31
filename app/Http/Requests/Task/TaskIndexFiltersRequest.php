<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskIndexFiltersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'taskStatusId' => 'nullable|exists:task_statuses,id',
            'perPage' => 'nullable|integer|min:10|max:100',
            'orderBy' => 'nullable|array',
            'orderBy.field' => 'nullable|string',
            'orderBy.direction' => 'nullable|in:asc,desc',
        ];
    }
}
