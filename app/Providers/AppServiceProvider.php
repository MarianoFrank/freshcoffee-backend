<?php

namespace App\Providers;

use App\Services\Auth\JwtGuard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!$this->app->isProduction());

        // Registro del guard personalizado
        Auth::extend('jwt', function ($app, $name, array $config) {
            // Aquí obtenemos el Request desde el contenedor de la aplicación.
            return new JwtGuard(Auth::createUserProvider($config['provider']), $app['request']);
        });
    }
}
