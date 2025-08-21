<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if 2FA is enabled but not yet confirmed
        if (
            $user &&
            $user->two_factor_secret && // User enabled 2FA
            is_null($user->two_factor_confirmed_at) // Not confirmed yet
        ) {
            return redirect()->route('two-factor.confirm.show');
        }

        return $next($request);
    }
}
