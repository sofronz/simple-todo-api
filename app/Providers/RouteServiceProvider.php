<?php
namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mapApiRoutes();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
