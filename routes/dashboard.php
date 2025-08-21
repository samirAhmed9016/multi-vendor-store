<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CheckUserTypeMiddleware;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\Configuration\Group;

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




Route::middleware(['auth'])->group(function () {});


Route::group([
    'middleware' => ['auth:admin,web'],
    'as' => 'dashboard.',
    'prefix' => 'admin/dashboard'
], function () {




    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    Route::get('categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');






    Route::resource('dashboard/categories', CategoriesController::class)
        // ->names([
        //     'index' => 'dashboard.categories.index',
        //     'create' => 'dashboard.categories.create',
        //     'store' => 'dashboard.categories.store',
        //     'show' => 'dashboard.categories.show',
        //     'edit' => 'dashboard.categories.edit',
        //     'update' => 'dashboard.categories.update',
        //     'destroy' => 'dashboard.categories.destroy',
        // ]);
    ;
    Route::resource('dashboard/products', ProductController::class);
    Route::resource('dashboard/roles', RolesController::class);
});
