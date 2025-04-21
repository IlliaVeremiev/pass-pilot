<?php

namespace App\Http\Resources;

use App\Models\Organization;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicOrganizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Organization $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'plans' => $this->activePlans->map(fn (Plan $plan) => [
                'id' => $plan->id,
                'name' => $plan->name,
                'description' => $plan->description,
                'duration' => $plan->duration,
                'price' => $plan->price,
            ]),
        ];
    }
}
