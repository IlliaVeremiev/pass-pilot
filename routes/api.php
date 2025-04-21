<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/organizations/{id}', [OrganizationController::class, 'getById']);

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'registerCustomer']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth', [AuthenticationController::class, 'auth']);
});
