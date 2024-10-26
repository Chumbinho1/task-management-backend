<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class AuthService
{
    public function __construct(
        protected User $userModel
    ) {}

    public function signup(array $data): User
    {
        return $this->userModel->create(convertKeysToSnakeCase($data));
    }

    public function signin(array $data): NewAccessToken
    {
        $user = $this->userModel->where('email', $data['email'])->first();

        throw_if(! $user || ! password_verify($data['password'], $user->password), InvalidCredentialsException::class, 'Invalid credentials.');

        return $user->createToken('authToken');
    }
}
