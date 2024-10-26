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

    public function test_task_store_route(): void
    {
        $response = $this->actingAs($this->user)->postJson($this->endpoint, [
            'title' => 'Task title',
            'description' => 'Task description',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonFragment([
            'message' => 'Task created successfully!',
        ]);
    }

    public function test_task_store_route_without_description(): void
    {
        $response = $this->actingAs($this->user)->postJson($this->endpoint, [
            'title' => 'Task title',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonFragment([
            'message' => 'Task created successfully!',
        ]);
    }

    public function test_task_store_route_without_title(): void
    {
        $response = $this->actingAs($this->user)->postJson($this->endpoint, [
            'description' => 'Task description',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'title',
        ]);
    }

    public function test_task_store_route_without_parameters(): void
    {
        $response = $this->actingAs($this->user)->postJson($this->endpoint, []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'title',
        ]);
    }

    public function test_task_store_route_unauthenticated(): void
    {
        $response = $this->postJson($this->endpoint, [
            'title' => 'Task title',
            'description' => 'Task description',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
