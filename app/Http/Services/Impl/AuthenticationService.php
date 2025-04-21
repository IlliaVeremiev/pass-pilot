<?php

namespace App\Http\Services\Impl;

use App\Exceptions\UnauthorizedException;
use App\Http\Dto\Auth\ExternalAuthenticationResult;
use App\Http\Dto\Auth\LoginForm;
use App\Http\Dto\Auth\RegisterCustomerForm;
use App\Http\Repositories\SocialAccountRepositoryInterface;
use App\Http\Repositories\UserRepositoryInterface;
use App\Http\Services\AuthenticationServiceInterface;
use App\Http\Services\UserServiceInterface;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Facades\Auth;
use Nette\NotImplementedException;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly HashManager $hashManager,
        private readonly SocialAccountRepositoryInterface $socialAccountRepository,
        private readonly UserServiceInterface $userService
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

    public function handleExternalAuthentication(string $provider, string $idToken): string
    {
        if ($provider == 'google') {
            $response = $this->handleGoogleAuthentication($idToken);
        } else {
            throw new NotImplementedException('Unsupported authentication provider ' . $provider);
        }

        $socialAccount = new SocialAccount;
        $socialAccount->user_id = $response->user->id;
        $socialAccount->provider = $provider;
        $socialAccount->payload = $response->payload;
        $this->socialAccountRepository->save($socialAccount);

        return $this->generateToken($response->user);
    }

    private function handleGoogleAuthentication(string $idToken): ExternalAuthenticationResult
    {
        $googleClient = new \Google\Client;
        $googleClient->setClientId(config('services.google.client_id'));
        $googleClient->setClientSecret(config('services.google.client_secret'));
        $response = $googleClient->verifyIdToken($idToken);
        $email = $response['email'];
        $name = $response['name'];
        $user = $this->userRepository->findByEmail($email);
        if ($user !== null) {
            return new ExternalAuthenticationResult($user, $response);
        }

        return new ExternalAuthenticationResult($this->userService->registerCustomer(new RegisterCustomerForm($email, null, $name)), $response);
    }
}
