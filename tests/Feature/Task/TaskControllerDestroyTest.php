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

    public function testSuccessfullyDeleteTask(): void
    {
        $response = $this->actingAs($this->user)->deleteJson($this->getTaskEndpoint($this->task->id));
        $response->assertOk()->assertJsonFragment(['message' => 'Task deleted successfully!']);
    }

    public function testDeleteTaskWhileUnauthenticated(): void
    {
        $response = $this->deleteJson($this->getTaskEndpoint($this->task->id));
        $response->assertUnauthorized();
    }

    public function testDeleteNonExistentTask(): void
    {
        $response = $this->actingAs($this->user)->deleteJson($this->getTaskEndpoint('invalid-id'));
        $response->assertNotFound();
    }

    private function getTaskEndpoint(string $taskId): string
    {
        return "{$this->endpoint}/{$taskId}";
    }
}
