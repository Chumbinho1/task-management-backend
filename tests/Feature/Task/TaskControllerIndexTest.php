<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class TaskControllerIndexTest extends TestCase
{
    protected const ENDPOINT = '/api/tasks';
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->createTasks();
    }

    private function createTasks(): void
    {
        Task::factory()->createMany([
            $this->createTaskData('Task title 1', 'Task description 1', 'to-do'),
            $this->createTaskData('Task title 2', 'Task description 2', 'in-progress'),
            $this->createTaskData('Task title 3', 'Task description 3', 'done'),
        ]);
    }

    private function createTaskData(string $title, string $description, string $statusSlug): array
    {
        return [
            'title' => $title,
            'description' => $description,
            'task_status_id' => TaskStatus::firstWhere('slug', $statusSlug)->id,
        ];
    }

    public function testIndexRouteUnauthenticated(): void
    {
        $response = $this->getJson(self::ENDPOINT);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testIndexRoute(): void
    {
        $response = $this->makeApiCall();
        $response->assertOk();
    }

    public function testIndexRouteJsonStructure(): void
    {
        $response = $this->makeApiCall();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'taskStatus' => [
                        'id',
                        'description',
                        'slug',
                    ],
                ],
            ],
        ]);
    }

    public function testIndexRouteWithTitleFilter(): void
    {
        $this->testFilter('title', 'Task title 1');
    }

    public function testIndexRouteWithDescriptionFilter(): void
    {
        $this->testFilter('description', 'Task description 1');
    }

    public function testIndexRouteWithTaskStatusIdFilter(): void
    {
        $this->testFilter('taskStatusId', TaskStatus::firstWhere('slug', 'in-progress')->id);
    }

    public function testIndexRouteWithInvalidTaskStatusIdFilter(): void
    {
        $response = $this->makeApiCall(['taskStatusId' => 'asd']);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['taskStatusId']);
    }

    public function testIndexRouteWithPerPageFilter(): void
    {
        Task::factory(100)->create();
        $response = $this->makeApiCall(['perPage' => 30]);
        $response->assertOk();
        $this->assertCount(30, $response->json('data'));
    }

    public function testIndexRouteWithBelowMinimumPerPageFilter(): void
    {
        Task::factory(100)->create();
        $response = $this->makeApiCall(['perPage' => 9]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('perPage');
    }

    public function testIndexRouteWithAboveMaximumPerPageFilter(): void
    {
        Task::factory(100)->create();
        $response = $this->makeApiCall(['perPage' => 101]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('perPage');
    }

    private function makeApiCall(array $params = []): TestResponse
    {
        $query = http_build_query($params);
        return $this->actingAs($this->user)->getJson(self::ENDPOINT . ($query ? "?{$query}" : ''));
    }

    private function testFilter(string $filter, string|int $value): void
    {
        $response = $this->makeApiCall([$filter => $value]);
        $data = $response->json('data');
        if (is_array($data)) {
            $this->assertCount(1, $data);
        }
    }
}
