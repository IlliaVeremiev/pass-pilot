<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use RuntimeException;

class ConflictException extends RuntimeException
{
    public function render(): Response
    {
        return response(['message' => $this->message], Response::HTTP_CONFLICT);
    }
}
