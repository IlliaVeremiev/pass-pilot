<?php

namespace App\Http\Services;

use App\Http\Dto\Auth\RegisterCustomerForm;

interface UserServiceInterface
{
    public function registerCustomer(RegisterCustomerForm $form): void;
}
