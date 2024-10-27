<?php

namespace Tests\Feature\TaskStatus;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskStatusControllerIndexTest extends TestCase
{
    protected string $endpoint = '/api/task-statuses';

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_task_status_index_route(): void
    {
        $response = $this->actingAs($this->user)->getJson($this->endpoint);

        $response->assertOk();
    }

    public function test_task_status_index_route_json_structure(): void
    {
        $response = $this->actingAs($this->user)->getJson($this->endpoint);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'description',
                    'slug',
                    'order',
                ],
            ],
        ]);
    }

    public function test_task_status_index_route_unauthenticated(): void
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
