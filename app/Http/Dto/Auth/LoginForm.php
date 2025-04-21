<?php

namespace App\Http\Dto\Auth;

use Spatie\LaravelData\Data;

class LoginForm extends Data
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
