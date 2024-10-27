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
                'position' => 1,
            ],
            [
                'description' => 'In Progress',
                'slug' => 'in-progress',
                'position' => 2,
            ],
            [
                'description' => 'Done',
                'slug' => 'done',
                'position' => 3,
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
