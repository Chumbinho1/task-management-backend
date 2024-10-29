<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AuthControllerSignInTest extends TestCase
{
    private const CORRECT_EMAIL = 'teste@teste.com';
    private const INCORRECT_EMAIL = 'incorrect@teste.com';

    protected string $endpoint = '/api/auth/signin';

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => self::CORRECT_EMAIL,
        ]);
    }

    public function test_sign_in_route(): void
    {
        $response = $this->makeSignInRequest(self::CORRECT_EMAIL, 'password');

        $response->assertOk();
        $response->assertJsonStructure([
            'accessToken',
        ]);
    }

    public function test_sign_in_with_incorrect_email(): void
    {
        $response = $this->makeSignInRequest(self::INCORRECT_EMAIL, 'password');

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_sign_in_with_incorrect_password(): void
    {
        $response = $this->makeSignInRequest(self::CORRECT_EMAIL, 'incorrect');

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    private function makeSignInRequest(string $email, string $password): TestResponse
    {
        return $this->postJson($this->endpoint, [
            'email' => $email,
            'password' => $password,
        ]);
    }
}
