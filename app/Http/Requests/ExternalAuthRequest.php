<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExternalAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'provider' => 'required|string',
            'idToken' => 'required|string',
        ];
    }
}
