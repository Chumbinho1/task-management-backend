<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class TaskControllerShowTest extends TestCase
{
    protected string $endpoint = '/api/tasks';

    protected User $user;

    protected Task $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create([
            'task_status_id' => TaskStatus::firstWhere('slug', 'to-do')->id,
        ]);
    }

    public function test_show_task(): void
    {
        $response = $this->showTask();
        $response->assertOk();
        $response->assertExactJsonStructure([
            'id',
            'title',
            'description',
            'taskStatus' => [
                'id',
                'description',
                'slug',
                'order',
            ],
            'createdAt',
            'updatedAt',
        ]);
    }

    public function test_show_task_unauthenticated(): void
    {
        $response = $this->getJson("{$this->endpoint}/{$this->task->id}");
        $response->assertUnauthorized();
    }

    public function test_show_task_invalid_task_id(): void
    {
        $response = $this->actingAs($this->user)->getJson("{$this->endpoint}/teste");
        $response->assertNotFound();
    }

    private function showTask(): TestResponse
    {
        return $this->actingAs($this->user)->getJson("{$this->endpoint}/{$this->task->id}");
    }
}
