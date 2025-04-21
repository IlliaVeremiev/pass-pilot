<?php

namespace App\Http\Repositories\Impl;

use App\Http\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    public function getByEmail(string $email): User
    {
        return User::query()->where('email', $email)->firstOrFail();
    }

    public function save(User $user): User
    {
        $user->saveOrFail();

        return $user;
    }
}
