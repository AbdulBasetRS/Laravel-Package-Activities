<?php

namespace Abdulbaset\Activities\Providers;

use Illuminate\Support\ServiceProvider;

class ActivitiesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/ActivityConfig.php', 'ActivityConfig');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
        $this->publishes([__DIR__.'/../Config/ActivityConfig.php' => config_path('ActivityConfig.php'),], 'ActivityConfig');
    }
}
