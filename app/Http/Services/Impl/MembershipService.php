<?php

namespace App\Http\Services\Impl;

use App\Http\Dto\Membership\CreateMembershipDto;
use App\Http\Repositories\MembershipRepositoryInterface;
use App\Http\Repositories\PlanRepositoryInterface;
use App\Http\Repositories\UserRepositoryInterface;
use App\Http\Services\MembershipServiceInterface;
use App\Models\Membership;
use Illuminate\Support\Facades\DB;

class MembershipService implements MembershipServiceInterface
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly MembershipRepositoryInterface $membershipRepository,
    ) {}

    public function createMembership(CreateMembershipDto $form): Membership
    {
        return DB::transaction(function () use ($form) {
            $plan = $this->planRepository->getById($form->planId);
            $user = $this->userRepository->getByEmail($form->userEmail);

            $membership = new Membership;
            $membership->organization_id = $plan->organization_id;
            $membership->plan_id = $plan->id;
            $membership->user_id = $user->id;
            $membership->start_at = $form->startAt;
            $membership->end_at = $form->endAt;

            return $this->membershipRepository->save($membership);
        });
    }
}
