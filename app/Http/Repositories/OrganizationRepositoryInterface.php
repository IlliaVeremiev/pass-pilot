<?php

namespace App\Http\Repositories;

use App\Models\Organization;

interface OrganizationRepositoryInterface
{
    public function getById(string $id): Organization;
}
