<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthSigninRequest;
use App\Http\Requests\Auth\AuthSignupRequest;
use App\Http\Resources\Auth\SigninResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function signup(
        AuthSignupRequest $request
    ): JsonResponse {
        try {
            $this->authService->signup($request->validated());

            return created('Signed up successfully!');
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }

    public function signin(
        AuthSigninRequest $request
    ): JsonResponse {
        try {
            return ok(SigninResource::make($this->authService->signin($request->validated())));
        } catch (InvalidCredentialsException $e) {
            return unauthorized($e->getMessage());
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }

    public function signout(): JsonResponse
    {
        try {
            $this->authService->signout();

            return ok(['message' => 'Signed out successfully!']);
        } catch (\Exception $e) {
            return internalServerError($e);
        }
    }
}
