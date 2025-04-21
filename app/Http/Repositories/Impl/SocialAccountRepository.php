<?php

namespace App\Http\Repositories\Impl;

use App\Http\Repositories\SocialAccountRepositoryInterface;
use App\Models\SocialAccount;

class SocialAccountRepository implements SocialAccountRepositoryInterface
{
    public function save(SocialAccount $socialAccount): SocialAccount
    {
        $socialAccount->save();

        return $socialAccount;
    }
}
