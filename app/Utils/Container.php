<?php

namespace App\Utils;

use App\Http\Repositories\PlanRepositoryInterface;
use App\Http\Repositories\UserRepositoryInterface;
use App\Http\Services\MembershipServiceInterface;
use Illuminate\Support\Facades\App;

abstract class Container
{
    public static function membershipService(): MembershipServiceInterface
    {
        return App::make(MembershipServiceInterface::class);
    }

    public static function userRepository(): UserRepositoryInterface
    {
        return App::make(UserRepositoryInterface::class);
    }

    public static function planRepository(): PlanRepositoryInterface
    {
        return App::make(PlanRepositoryInterface::class);
    }
}
