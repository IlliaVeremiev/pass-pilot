<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnauthorizedException extends Exception
{
    public function render(Request $request): Response
    {
        return response(['message' => $this->message], Response::HTTP_UNAUTHORIZED);
    }
}
