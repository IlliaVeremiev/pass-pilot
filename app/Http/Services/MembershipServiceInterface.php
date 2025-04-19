<?php

namespace App\Http\Services;

use App\Http\Dto\Membership\CreateMembershipDto;
use App\Models\Membership;

interface MembershipServiceInterface
{
    public function createMembership(CreateMembershipDto $form): Membership;
}
