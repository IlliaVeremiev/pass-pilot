<?php

namespace App\Http\Dto\Membership;

use Carbon\Carbon;
use DateTimeInterface;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class CreateMembershipDto extends Data
{
    public function __construct(
        #[MapInputName('plan_id')]
        public string $planId,
        #[MapInputName('user_email')]
        public string $userEmail,
        #[MapInputName('start_at')]
        #[WithCast(DateTimeInterfaceCast::class, format: DateTimeInterface::ATOM)]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: DateTimeInterface::ATOM)]
        public Carbon $startAt,
        #[MapInputName('end_at')]
        #[WithCast(DateTimeInterfaceCast::class, format: DateTimeInterface::ATOM)]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: DateTimeInterface::ATOM)]
        public Carbon $endAt
    ) {}
}
