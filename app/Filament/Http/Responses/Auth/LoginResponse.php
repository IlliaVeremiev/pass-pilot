<?php

namespace App\Filament\Http\Responses\Auth;

use App\Filament\Pages\MerchantDashboard;
use Filament\Http\Responses\Auth\LoginResponse as BaseLoginResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse extends BaseLoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        return redirect()->to(MerchantDashboard::getUrl(panel: 'merchant'));
    }
}
