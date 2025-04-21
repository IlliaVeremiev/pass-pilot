<?php

namespace App\Http\Requests;

use Spatie\LaravelData\Data;

interface DtoConvertible
{
    public function toDto(): Data;
}
