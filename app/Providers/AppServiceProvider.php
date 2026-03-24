<?php

namespace App\Providers;

use App\Services\EvolutionApiService;
use App\Services\WhatsappInstanceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(EvolutionApiService::class);
        $this->app->singleton(WhatsappInstanceService::class);
    }

    public function boot(): void
    {
        //
    }
}
