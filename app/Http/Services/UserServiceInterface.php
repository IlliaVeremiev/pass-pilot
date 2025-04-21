<?php

namespace App\Http\Services;

use App\Http\Dto\Auth\RegisterCustomerForm;
use App\Models\User;

interface UserServiceInterface
{
    public function registerCustomer(RegisterCustomerForm $form): User;
}
