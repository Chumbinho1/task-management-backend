<?php

use App\Models\TaskStatus;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $taskStatuses = [
            [
                'description' => 'To Do',
                'slug' => 'to-do',
            ],
            [
                'description' => 'In Progress',
                'slug' => 'in-progress',
            ],
            [
                'description' => 'Done',
                'slug' => 'done',
            ],
        ];

        foreach ($taskStatuses as $taskStatus) {
            TaskStatus::create($taskStatus);
        }
    }

    public function down(): void
    {
        TaskStatus::truncate();
    }
};
