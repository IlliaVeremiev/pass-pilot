<?php

namespace App\Http\Services;

use App\Http\Dto\Auth\LoginForm;
use App\Models\User;

interface AuthenticationServiceInterface
{
    public function authenticate(LoginForm $form): string;

    public function generateToken(User $user): string;

    public function getAuthenticatedUser(): User;
}
