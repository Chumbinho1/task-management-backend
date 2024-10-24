<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ){}
    public function signup(
        SignupRequest $request
    ): JsonResponse
    {
        try {
            $this->authService->signup($request->validated());
            return created('Signed up successfully!');
        } catch (\Exception $e) {
            return internalServerError();
        }
    }
}
