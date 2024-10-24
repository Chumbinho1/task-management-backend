<?php

namespace App\Services\Auth;

use App\Models\User;

class AuthService
{
    public function __construct(
        protected User $userModel
    )
    {
    }

    public function signup(array $data): User
    {
        return $this->userModel->create($data);
    }
}
