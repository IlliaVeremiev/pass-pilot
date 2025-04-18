<?php

namespace App\Providers;

use App\Livewire\Synth\BigDecimalSynth;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

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
        //
    }
}
