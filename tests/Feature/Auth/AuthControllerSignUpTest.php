<?php
namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthControllerSignUpTest extends TestCase
{
    protected string $endpoint = '/api/auth/signup';
    private const TEST_USER_NAME = 'Test User';
    private const TEST_USER_EMAIL = 'teste@teste.com';
    private const TEST_USER_PASSWORD = 'password';
    private const TEST_USER_WRONG_CONFIRMATION = 'password2';

    public function test_sign_up_route(): void
    {
        $response = $this->postJson($this->endpoint, $this->getSignUpPayload());

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_sign_up_with_incorrect_password_confirmation(): void
    {
        $response = $this->postJson($this->endpoint, $this->getSignUpPayload(self::TEST_USER_WRONG_CONFIRMATION));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['passwordConfirmation']);
    }

    public function test_sign_up_with_already_registered_email(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson($this->endpoint, $this->getSignUpPayload(confirmPassword: self::TEST_USER_PASSWORD, email: $user->email));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email']);
    }

    private function getSignUpPayload(string $confirmPassword = self::TEST_USER_PASSWORD, string $email = self::TEST_USER_EMAIL): array
    {
        return [
            'name' => self::TEST_USER_NAME,
            'email' => $email,
            'password' => self::TEST_USER_PASSWORD,
            'passwordConfirmation' => $confirmPassword,
        ];
    }
}
