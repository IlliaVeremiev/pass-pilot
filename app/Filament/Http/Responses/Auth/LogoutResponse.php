<?php

namespace App\Filament\Http\Responses\Auth;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\LogoutResponse as BaseLogoutResponse;
use Illuminate\Http\RedirectResponse;

class LogoutResponse extends BaseLogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        if (Filament::getCurrentPanel()->getId() === 'organization') {
            return redirect()->to(Filament::getPanel('merchant')->getLoginUrl());
        }

        return parent::toResponse($request);
    }
}
