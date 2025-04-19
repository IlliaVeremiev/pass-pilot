<?php

namespace App\Http\Repositories\Impl;

use App\Http\Repositories\MembershipRepositoryInterface;
use App\Models\Membership;

class MembershipRepository implements MembershipRepositoryInterface
{
    public function save(Membership $membership): Membership
    {
        $membership->saveOrFail();

        return $membership;
    }
}
