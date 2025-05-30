<?php

namespace App\Providers;

use App\Http\Repositories\Impl\MembershipRepository;
use App\Http\Repositories\Impl\OrganizationRepository;
use App\Http\Repositories\Impl\PlanRepository;
use App\Http\Repositories\Impl\SocialAccountRepository;
use App\Http\Repositories\Impl\UserRepository;
use App\Http\Repositories\MembershipRepositoryInterface;
use App\Http\Repositories\OrganizationRepositoryInterface;
use App\Http\Repositories\PlanRepositoryInterface;
use App\Http\Repositories\SocialAccountRepositoryInterface;
use App\Http\Repositories\UserRepositoryInterface;
use App\Http\Services\AuthenticationServiceInterface;
use App\Http\Services\Impl\AuthenticationService;
use App\Http\Services\Impl\MembershipService;
use App\Http\Services\Impl\UserService;
use App\Http\Services\MembershipServiceInterface;
use App\Http\Services\UserServiceInterface;
use App\Livewire\Synth\BigDecimalSynth;
use App\Models\PersonalAccessToken;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SocialAccountRepositoryInterface::class, SocialAccountRepository::class);
        $this->app->singleton(MembershipRepositoryInterface::class, MembershipRepository::class);
        $this->app->singleton(OrganizationRepositoryInterface::class, OrganizationRepository::class);
        $this->app->singleton(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);

        $this->app->singleton(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->singleton(MembershipServiceInterface::class, MembershipService::class);
        $this->app->singleton(UserServiceInterface::class, UserService::class);

        $this->app->singleton(
            \Filament\Http\Responses\Auth\Contracts\LoginResponse::class,
            \App\Filament\Http\Responses\Auth\LoginResponse::class,
        );
        $this->app->singleton(
            \Filament\Http\Responses\Auth\Contracts\LogoutResponse::class,
            \App\Filament\Http\Responses\Auth\LogoutResponse::class,
        );
        Livewire::propertySynthesizer(BigDecimalSynth::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
