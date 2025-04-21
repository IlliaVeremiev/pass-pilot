<?php

namespace App\Http\Services\Impl;

use App\Exceptions\ConflictException;
use App\Http\Dto\Auth\RegisterCustomerForm;
use App\Http\Repositories\UserRepositoryInterface;
use App\Http\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Hashing\HashManager;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly HashManager $hashManager
    ) {
    }

    public function registerCustomer(RegisterCustomerForm $form): void
    {
        $existingUser = $this->userRepository->findByEmail($form->email);
        if ($existingUser !== null) {
            throw new ConflictException('User with provided email already exists.');
        }
        $user = new User;
        $user->email = $form->email;
        $user->password = $this->hashManager->make($form->password);
        $user->name = $form->name;
        $this->userRepository->save($user);
    }
}
