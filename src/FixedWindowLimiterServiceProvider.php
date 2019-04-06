<?php

namespace BeyondCode\FixedWindowLimiter;

use Illuminate\Support\ServiceProvider;

class FixedWindowLimiterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/limiter.php' => config_path('limiter.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/limiter.php', 'limiter');
    }
}
