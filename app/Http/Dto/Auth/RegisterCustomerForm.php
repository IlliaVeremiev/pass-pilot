<?php

namespace App\Http\Dto\Auth;

use Spatie\LaravelData\Data;

class RegisterCustomerForm extends Data
{
    public function __construct(
        public string $email,
        public string $password,
        public string $name
    ) {}
}
