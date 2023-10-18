<?php

declare(strict_types=1);

namespace App\Providers;

use App\Parent\Providers\JsonApiPaginateServiceProvider;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        (new JsonApiPaginateServiceProvider($this->app))->registerMacro();
    }
}
