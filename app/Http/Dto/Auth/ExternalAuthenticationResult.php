<?php

namespace App\Http\Dto\Auth;

use App\Models\User;

class ExternalAuthenticationResult
{
    public function __construct(
        public readonly User $user,
        public readonly array $payload,
    ) {}
}
