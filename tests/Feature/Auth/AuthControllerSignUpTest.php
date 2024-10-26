<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthControllerSignUpTest extends TestCase
{
    protected string $endpoint = '/api/auth/signup';

    public function test_sign_up_route(): void
    {
        $response = $this->postJson($this->endpoint, [
            'name' => 'Test User',
            'email' => 'teste@teste.com',
            'password' => 'password',
            'passwordConfirmation' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_sign_up_with_incorrect_password_confirmation(): void
    {
        $response = $this->postJson($this->endpoint, [
            'name' => 'Test User',
            'email' => 'teste@teste.com',
            'password' => 'password',
            'passwordConfirmation' => 'password2',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'passwordConfirmation',
        ]);
    }

    public function test_sign_up_with_already_registered_email(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson($this->endpoint, [
            'name' => 'Test User',
            'email' => $user->email,
            'password' => 'password',
            'passwordConfirmation' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'email',
        ]);
    }
}
