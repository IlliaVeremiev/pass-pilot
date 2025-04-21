<?php

namespace App\Http\Requests\Auth;

use App\Http\Dto\Auth\LoginForm;
use App\Http\Requests\DtoConvertible;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest implements DtoConvertible
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function toDto(): LoginForm
    {
        return LoginForm::from($this);
    }
}
