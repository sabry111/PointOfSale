<?php

use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\ClientController;
use App\Http\Controllers\dashboard\clients\OrderController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\OrderGenralController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

// localization for arabic and english lang to site

// Route::group(
//     [
//         'prefix' => LaravelLocalization::setLocale(),
//         'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
//     ],
//     function () {
Route::get('/', function () {
    return view('auth.login');
});


// Route::namespace('App\Http\Controllers\Admin')->group(function () {});


Auth::routes();

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::get('/index', [DashboardController::class, 'index'])->name('index');
        // Users route
        Route::resource('users', UserController::class);
        // Categories route
        Route::resource('categories', CategoryController::class);
        // Proudects route
        Route::resource('products', ProductController::class);
        // Clients route
        Route::resource('clients', ClientController::class);
        Route::resource('clients.orders', OrderController::class);
        // Orders route
        Route::resource('orders', OrderGenralController::class);
    });
});
//     }
// );
