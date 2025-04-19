<?php

namespace App\Http\Repositories;

use App\Models\Plan;

interface PlanRepositoryInterface
{
    public function getById(string $id): Plan;

    public function findById(string $id): ?Plan;
}
