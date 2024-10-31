<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AuthControllerSignoutTest extends TestCase
{
    protected string $endpoint = '/api/auth/signout';

    protected string $signInEndpoint = '/api/auth/signin';

    protected User $user;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('default')->plainTextToken;
    }

    public function test_signout_route(): void
    {
        $response = $this->makeSignoutRequest();

        $response->assertOk();
        $response->assertExactJsonStructure([
            'message',
        ]);
    }

    public function test_signout_route_without_token(): void
    {
        $response = $this->deleteJson($this->endpoint);

        $response->assertUnauthorized();
        $response->assertExactJsonStructure([
            'message',
        ]);
    }

    private function makeSignoutRequest(): TestResponse
    {
        return $this->withHeader('Authorization', "Bearer {$this->token}")->deleteJson($this->endpoint);
    }
}
