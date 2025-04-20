<?php

namespace App\Providers;

use App\Http\Repositories\Impl\MembershipRepository;
use App\Http\Repositories\Impl\PlanRepository;
use App\Http\Repositories\Impl\UserRepository;
use App\Http\Repositories\MembershipRepositoryInterface;
use App\Http\Repositories\PlanRepositoryInterface;
use App\Http\Repositories\UserRepositoryInterface;
use App\Http\Services\Impl\MembershipService;
use App\Http\Services\MembershipServiceInterface;
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
        $this->app->singleton(MembershipRepositoryInterface::class, MembershipRepository::class);
        $this->app->singleton(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);

        $this->app->singleton(MembershipServiceInterface::class, MembershipService::class);

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
