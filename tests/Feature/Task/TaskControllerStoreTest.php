<?php

namespace Tests\Feature\Task;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerStoreTest extends TestCase
{
    protected string $endpoint = '/api/tasks';
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_task_store_with_valid_data(): void
    {
        $this->assertStoreResponse([
            'title' => 'Task title',
            'description' => 'Task description',
        ], Response::HTTP_CREATED, [
            'message' => 'Task created successfully!',
        ]);

        $this->assertStoreResponse([
            'title' => 'Task title',
        ], Response::HTTP_CREATED, [
            'message' => 'Task created successfully!',
        ]);
    }

    public function test_task_store_with_missing_title(): void
    {
        $this->assertStoreResponse([
            'description' => 'Task description',
        ], Response::HTTP_UNPROCESSABLE_ENTITY, [
            'errors' => ['title'],
        ], true);
    }

    public function test_task_store_with_missing_parameters(): void
    {
        $this->assertStoreResponse([], Response::HTTP_UNPROCESSABLE_ENTITY, [
            'errors' => ['title'],
        ], true);
    }

    public function test_task_store_unauthenticated(): void
    {
        $response = $this->postJson($this->endpoint, [
            'title' => 'Task title',
            'description' => 'Task description',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    private function assertStoreResponse(array $data, int $status, array $jsonFragment, bool $checkErrors = false): void
    {
        $response = $this->actingAs($this->user)->postJson($this->endpoint, $data);

        $response->assertStatus($status);

        if ($checkErrors) {
            $response->assertJsonValidationErrors($jsonFragment['errors']);
        } else {
            $response->assertJsonFragment($jsonFragment);
        }
    }
}
