<?php

namespace Tests\Feature\TaskStatus;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class TaskStatusControllerIndexTest extends TestCase
{
    protected string $endpoint = '/api/task-statuses';

    protected User $user;

    private const JSON_STRUCTURE = [
        'data' => [
            '*' => [
                'id',
                'description',
                'slug',
                'order',
            ],
        ],
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_task_status_index_route(): void
    {
        $response = $this->makeAuthenticatedRequest();
        $response->assertOk();
    }

    public function test_task_status_index_route_json_structure(): void
    {
        $response = $this->makeAuthenticatedRequest();
        $response->assertJsonStructure(self::JSON_STRUCTURE);
    }

    public function test_task_status_index_route_unauthenticated(): void
    {
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    private function makeAuthenticatedRequest(): TestResponse
    {
        return $this->actingAs($this->user)->getJson($this->endpoint);
    }
}
