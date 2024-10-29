<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class ValidateTokenLogoutAll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //comprueba si el usuario cerro sesion en todas las pc's

        $user = auth()->user();

        if ($user && $user->logout_all) {
            $tokenLastLoggedOut = auth()->payload()->get('logout_all');

            $tokenLastLoggedOut = $tokenLastLoggedOut ? Carbon::parse($tokenLastLoggedOut) : null;
            $userLogoutTimestamp = $user->logout_all ? $user->logout_all : null;


            if ($tokenLastLoggedOut && $userLogoutTimestamp) {
                // Si el token tiene un valor menor, significa que el usuario actualizó "logout_all"
                if ($tokenLastLoggedOut < $userLogoutTimestamp) {
                    return response()->json(['error' => 'Token has been invalidated'], 401);
                }
            }

        }
        return $next($request);
    }
}
