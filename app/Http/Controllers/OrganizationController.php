<?php

namespace App\Http\Controllers;

use App\Http\Repositories\OrganizationRepositoryInterface;
use App\Http\Resources\PublicOrganizationResource;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    public function __construct(
        private readonly OrganizationRepositoryInterface $organizationRepository
    ) {}

    public function getById(string $id): JsonResponse
    {
        $organization = $this->organizationRepository->getById($id);

        return response()->json(PublicOrganizationResource::make($organization));
    }
}
