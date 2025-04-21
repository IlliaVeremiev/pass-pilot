<?php

namespace App\Http\Repositories\Impl;

use App\Http\Repositories\OrganizationRepositoryInterface;
use App\Models\Organization;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getById(string $id): Organization
    {
        return Organization::query()->findOrFail($id);
    }
}
