<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\ExternalAuthRequest;
use App\Http\Requests\RegisterCustomerRequest;
use App\Http\Resources\PublicAuthResponse;
use App\Http\Services\AuthenticationServiceInterface;
use App\Http\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthenticationController
{
    public function __construct(
        private readonly AuthenticationServiceInterface $authenticationService,
        private readonly UserServiceInterface $userService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authenticationService->authenticate($request->toDto());

        return response()->json(['token' => $token]);
    }

    public function auth(): JsonResponse
    {
        $user = $this->authenticationService->getAuthenticatedUser();

        return response()->json(PublicAuthResponse::make($user));
    }

    public function registerCustomer(RegisterCustomerRequest $request): Response
    {
        $this->userService->registerCustomer($request->toDto());

        return response()->noContent();
    }

    public function verifyExternalAuthentication(ExternalAuthRequest $request): JsonResponse
    {
        $token = $this->authenticationService->handleExternalAuthentication($request->get('provider'), $request->get('idToken'));

        return response()->json(['token' => $token]);
    }
}
