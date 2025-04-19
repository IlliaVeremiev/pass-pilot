<?php

namespace App\Http\Repositories\Impl;

use App\Http\Repositories\PlanRepositoryInterface;
use App\Models\Plan;

class PlanRepository implements PlanRepositoryInterface
{
    public function getById(string $id): Plan
    {
        return Plan::whereId($id)->firstOrFail();
    }

    public function findById(string $id): ?Plan
    {
        return Plan::whereId($id)->first();
    }
}
