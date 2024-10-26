<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerUpdateTest extends TestCase
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

    public function test_task_update_route(): void
    {
        $response = $this->actingAs($this->user)->putJson("{$this->endpoint}/{$this->task->id}", [
            'title' => 'Task title',
            'description' => 'Task description',
            'taskStatusId' => TaskStatus::firstWhere('slug', 'in-progress')->id,
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Task updated successfully!',
        ]);
    }

    public function test_task_update_route_update_title(): void
    {
        $response = $this->actingAs($this->user)->putJson("{$this->endpoint}/{$this->task->id}", [
            'title' => 'Task title',
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Task updated successfully!',
        ]);
    }

    public function test_task_update_route_update_description(): void
    {
        $response = $this->actingAs($this->user)->putJson("{$this->endpoint}/{$this->task->id}", [
            'description' => 'Task description',
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Task updated successfully!',
        ]);
    }

    public function test_task_update_route_update_task_status_id(): void
    {
        $response = $this->actingAs($this->user)->putJson("{$this->endpoint}/{$this->task->id}", [
            'taskStatusId' => TaskStatus::firstWhere('slug', 'in-progress')->id,
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Task updated successfully!',
        ]);
    }

    public function test_task_update_route_with_invalid_task_status_id(): void
    {
        $response = $this->actingAs($this->user)->putJson("{$this->endpoint}/{$this->task->id}", [
            'taskStatusId' => 'teste',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'taskStatusId',
        ]);
    }

    public function test_task_update_route_with_invalid_task_id(): void
    {
        $response = $this->actingAs($this->user)->putJson("{$this->endpoint}/teste", [
            'title' => 'Task title',
            'description' => 'Task description',
            'taskStatusId' => TaskStatus::firstWhere('slug', 'in-progress')->id,
        ]);

        $response->assertNotFound();
    }
}
