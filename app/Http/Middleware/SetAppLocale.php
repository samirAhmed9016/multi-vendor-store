<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        //$locale = request('locale', Cookie::get('locale', config('app.locale')));
        //Cookie::queue('locale', $locale, 60 * 24 * 30); // Store locale in cookie for 30 days


        $locale = $request->route('locale', 'en'); // Default to 'en' if no locale is provided in the route

        App::setLocale($locale);


        URL::defaults(['locale' => $locale]);
        Route::current()->forgetParameter('locale'); // Clear locale parameter from the route


        return $next($request);
    }
}
