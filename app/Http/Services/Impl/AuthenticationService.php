<?php

namespace App\Http\Services\Impl;

use App\Exceptions\UnauthorizedException;
use App\Http\Dto\Auth\LoginForm;
use App\Http\Repositories\UserRepositoryInterface;
use App\Http\Services\AuthenticationServiceInterface;
use App\Models\User;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Facades\Auth;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly HashManager $hashManager
    ) {}

    /**
     * @throws UnauthorizedException
     */
    public function authenticate(LoginForm $form): string
    {
        $user = $this->userRepository->findByEmail($form->email);
        if ($user === null) {
            throw new UnauthorizedException('Invalid credentials provided');
        }
        if (! $this->hashManager->check($form->password, $user->password)) {
            throw new UnauthorizedException('Invalid credentials provided');
        }

        return $this->generateToken($user);
    }

    public function generateToken(User $user): string
    {
        return $user->createToken('Tokenizer')->plainTextToken;
    }

    public function getAuthenticatedUser(): User
    {
        return Auth::user();
    }
}
