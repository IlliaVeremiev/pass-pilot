<?php

namespace App\Http\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function getByEmail(string $email): User;
}
