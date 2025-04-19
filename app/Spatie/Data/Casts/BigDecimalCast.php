<?php

namespace App\Spatie\Data\Casts;

use Brick\Math\BigDecimal;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class BigDecimalCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): ?BigDecimal
    {
        if ($value === null) {
            return null;
        }

        return BigDecimal::of($value);
    }
}
