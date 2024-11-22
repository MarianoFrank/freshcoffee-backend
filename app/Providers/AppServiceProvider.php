<?php

namespace App\Providers;

use App\Services\Auth\JwtGuard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;

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

        //registro un limitador 

        /* 
          TODO: Descomentar luego
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
        */

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return env('FRONTEND_URL')  . '/auth/new-password?token=' . $token . '&email=' . $user->email;
        });
    }
}
