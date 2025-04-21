<?php

namespace App\Http\Requests;

use App\Http\Dto\Auth\RegisterCustomerForm;
use Illuminate\Foundation\Http\FormRequest;

class RegisterCustomerRequest extends FormRequest implements DtoConvertible
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
            'name' => 'required|string|min:2',
        ];
    }

    public function toDto(): RegisterCustomerForm
    {
        return RegisterCustomerForm::from($this);
    }
}
