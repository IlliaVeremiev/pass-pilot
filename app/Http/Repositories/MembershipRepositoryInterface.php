<?php

namespace App\Http\Repositories;

use App\Models\Membership;

interface MembershipRepositoryInterface
{
    public function save(Membership $membership): Membership;
}
