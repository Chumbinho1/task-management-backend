<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Testing\TestResponse;
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

    public function test_update_task(): void
    {
        $this->updateTask([
            'title' => 'Task title',
            'description' => 'Task description',
            'taskStatusId' => TaskStatus::firstWhere('slug', 'in-progress')->id,
        ])->assertOk()->assertJsonFragment(['message' => 'Task updated successfully!']);
    }

    public function test_update_task_title_only(): void
    {
        $this->updateTask(['title' => 'Task title'])
            ->assertOk()
            ->assertJsonFragment(['message' => 'Task updated successfully!']);
    }

    public function test_update_task_description_only(): void
    {
        $this->updateTask(['description' => 'Task description'])
            ->assertOk()
            ->assertJsonFragment(['message' => 'Task updated successfully!']);
    }

    public function test_update_task_status_only(): void
    {
        $this->updateTask(['taskStatusId' => TaskStatus::firstWhere('slug', 'in-progress')->id])
            ->assertOk()
            ->assertJsonFragment(['message' => 'Task updated successfully!']);
    }

    public function test_update_task_unauthenticated(): void
    {
        $response = $this->putJson("{$this->endpoint}/{$this->task->id}", [
            'title' => 'Task title',
            'description' => 'Task description',
            'taskStatusId' => TaskStatus::firstWhere('slug', 'in-progress')->id,
        ]);
        $response->assertUnauthorized();
    }

    public function test_update_task_invalid_status_id(): void
    {
        $this->updateTask(['taskStatusId' => 'teste'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['taskStatusId']);
    }

    public function test_update_task_invalid_task_id(): void
    {
        $response = $this->actingAs($this->user)->putJson("{$this->endpoint}/teste", [
            'title' => 'Task title',
            'description' => 'Task description',
            'taskStatusId' => TaskStatus::firstWhere('slug', 'in-progress')->id,
        ]);
        $response->assertNotFound();
    }

    private function updateTask(array $data): TestResponse
    {
        return $this->actingAs($this->user)->putJson("{$this->endpoint}/{$this->task->id}", $data);
    }
}
