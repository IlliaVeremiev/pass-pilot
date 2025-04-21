<?php

namespace App\Http\Repositories;

use App\Models\SocialAccount;

interface SocialAccountRepositoryInterface
{
    public function save(SocialAccount $socialAccount): SocialAccount;
}
