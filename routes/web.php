<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function PHPUnit\Framework\isJson;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
], function () {



    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Route::get('/', function () {
    //     return view('welcome');
    // });

    // Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        // Route::get('dash', [DashboardController::class, 'index']);
        Route::get('dash', function () {
            return view('dashboard');
        });
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


    Route::get('products', [ProductsController::class, 'index'])->name('product.index');
    Route::get('products/{product:slug}', [ProductsController::class, 'show'])->name('product.show');


    // Route::resource('cart', CartController::class);





    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);

    Route::get('auth/user/2fa', [TwoFactorAuthenticationController::class, 'index'])->name('front.2fa');


    Route::post('currency', [CurrencyConverterController::class, 'store'])
        ->name('currency.store');





    Route::resources([
        'cart' => CartController::class,
        'categories' => CategoriesController::class,
    ]);






    Route::get('/two-factor/confirm', function () {
        return view('front.auth.two-factor-challenge');
    })->name('two-factor.confirm.show');
});


Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('auth.socialite.redirect');

Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('auth.socialite.callback');





//require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
