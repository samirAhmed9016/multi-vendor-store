<?php

namespace App\Providers;

use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', 'admin');
            // Config::set('fortify.home', 'admin/dashboard');
        }
        // $this->app->instance(LoginResponse::class, new class implements LoginResponse {
        //     public function toResponse($request)
        //     {
        //         if ($request->user('admin')) {
        //             return redirect()->intended('admin/dashboard/dashboard');
        //         } elseif ($request->user('web')) {
        //             return redirect()->intended('/');
        //         }
        //     }
        // });

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                $user = $request->user(config('fortify.guard'));

                // If user has enabled 2FA but not confirmed yet → go to confirmation page
                if ($user && $user->two_factor_secret && is_null($user->two_factor_confirmed_at)) {
                    return redirect()->route('two-factor.confirm.show');
                }

                // If using Fortify's normal 2FA challenge (already confirmed 2FA but needs login code)
                if ($request->session()->has('login.id')) {
                    return redirect()->route('two-factor.login');
                }

                // Otherwise go to normal dashboard
                if ($request->user('admin')) {
                    return redirect()->intended('admin/dashboard/dashboard');
                } elseif ($request->user('web')) {
                    return redirect()->intended('/');
                }
            }
        });













        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {

                return redirect()->intended('/');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {



        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

















        if (Config::get('fortify.guard') == 'admin') {
            Fortify::authenticateUsing([new AuthenticateUser, 'authenticate']);


            Fortify::viewPrefix('auth.');
        } else {
            Fortify::viewPrefix('front.auth.');


            Fortify::twoFactorChallengeView(function () {
                return view('front.auth.two-factor-challenge');
            });
        }
    }
}

// Fortify::loginView(fn() => view('auth.login'));
// Fortify::loginView(function () {
//     if (Config::get('fortify.guard') == 'web') {
//         return view('front.auth.login');
//     }
//     return view('auth.login');
// });
// Fortify::registerView('auth.register');
// Fortify::requestPasswordResetLinkView('auth.forgot-password');
// Fortify::resetPasswordView('auth.reset-password');
// Fortify::verifyEmailView('auth.verify-email');
