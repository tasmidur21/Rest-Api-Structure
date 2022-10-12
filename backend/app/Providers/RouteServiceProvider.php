<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        parent::boot();
        /**  $this->routes(function () {
         * Route::middleware('api')
         * ->prefix('api')
         * ->group(base_path('routes/api.php'));
         *
         * Route::middleware('web')
         * ->group(base_path('routes/web.php'));
         * }); */
    }


    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapApiV1Routes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define routes for api v2 routes
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiV1Routes(): void
    {
        /** Api Route */
        Route::middleware('api')
            ->prefix('api/v1')
            ->as('api.v1.')
            ->group(base_path('routes/api/v1/api.php'));

        /** Admin Api Route */
        Route::middleware('api')
            ->prefix('api/v1/admin')
            ->as('api.v1.admin.')
            ->namespace('App\Api\V1\Controllers')
            ->group(base_path('routes/api/v1/admin.php'));

    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
