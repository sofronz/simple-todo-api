<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\UserInterface::class,
            \App\Services\UserService::class
        );

        $this->app->bind(
            \App\Interfaces\TodoInterface::class,
            \App\Services\TodoService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
