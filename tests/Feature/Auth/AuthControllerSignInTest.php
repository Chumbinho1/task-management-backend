<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthControllerSignInTest extends TestCase
{
    protected string $endpoint = '/api/auth/signin';
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'teste@teste.com',
        ]);
    }

    public function test_sign_in_route(): void
    {
        $response = $this->postJson($this->endpoint, [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'accessToken'
        ]);
    }

    public function test_sign_in_with_incorrect_email(): void
    {
        $response = $this->postJson($this->endpoint, [
            'email' => 'incorrect@teste.com',
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_sign_in_with_incorrect_password(): void
    {
        $response = $this->postJson($this->endpoint, [
            'email' => 'teste@teste.com',
            'password' => 'incorrect',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response->assertJsonStructure([
            'message',
        ]);
    }
}
