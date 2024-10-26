<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskControllerDestroyTest extends TestCase
{
    protected string $endpoint = '/api/tasks';

    protected User $user;

    protected Task $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
    }

    public function test_task_destroy_route(): void
    {
        $response = $this->actingAs($this->user)->deleteJson("{$this->endpoint}/{$this->task->id}");

        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Task deleted successfully!',
        ]);
    }

    public function test_task_destroy_route_unauthenticated(): void
    {
        $response = $this->deleteJson("{$this->endpoint}/{$this->task->id}");

        $response->assertUnauthorized();
    }

    public function test_task_destroy_route_with_invalid_task_id(): void
    {
        $response = $this->actingAs($this->user)->deleteJson("{$this->endpoint}/teste");

        $response->assertNotFound();
    }
}
