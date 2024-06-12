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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::prefix('dashboard')->group(function () {

        Route::get('/index', [DashboardController::class, 'index'])->name('dashboard.index');

        // Users route

        Route::prefix('users')->group(function () {

            Route::get('/index', [UserController::class, 'index'])->name('dashboard.users.index');
            Route::get('/create', [UserController::class, 'create'])->name('dashboard.users.create');
            Route::post('/store', [UserController::class, 'store'])->name('dashboard.users.store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('dashboard.users.edit');
            Route::post('/update', [UserController::class, 'update'])->name('dashboard.users.update');
            Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('dashboard.users.delete');
        });

        // Categories route

        // Route::resource('categories', CategoryController::class)->except('show');

        Route::prefix('categories')->group(function () {

            Route::get('/index', [CategoryController::class, 'index'])->name('dashboard.categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('dashboard.categories.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('dashboard.categories.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('dashboard.categories.edit');
            Route::post('/update', [CategoryController::class, 'update'])->name('dashboard.categories.update');
            Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('dashboard.categories.delete');
        });

        // Proudects route

        Route::prefix('products')->group(function () {

            Route::get('/index', [ProductController::class, 'index'])->name('dashboard.products.index');
            Route::get('/create', [ProductController::class, 'create'])->name('dashboard.products.create');
            Route::post('/store', [ProductController::class, 'store'])->name('dashboard.products.store');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('dashboard.products.edit');
            Route::post('/update', [ProductController::class, 'update'])->name('dashboard.products.update');
            Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('dashboard.products.delete');
        });

        // Clients route

        Route::prefix('clients')->group(function () {

            Route::get('/index', [ClientController::class, 'index'])->name('dashboard.clients.index');
            Route::get('/create', [ClientController::class, 'create'])->name('dashboard.clients.create');
            Route::post('/store', [ClientController::class, 'store'])->name('dashboard.clients.store');
            Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('dashboard.clients.edit');
            Route::post('/update', [ClientController::class, 'update'])->name('dashboard.clients.update');
            Route::get('/delete/{id}', [ClientController::class, 'destroy'])->name('dashboard.clients.delete');

            Route::prefix('orders')->group(function () {

                Route::get('/index', [OrderController::class, 'index'])->name('dashboard.clients.orders.index');
                Route::get('/create/{client}', [OrderController::class, 'create'])->name('dashboard.clients.orders.create');
                Route::post('/store/{client}', [OrderController::class, 'store'])->name('dashboard.clients.orders.store');
                Route::get('/edit/{order}/{client}', [OrderController::class, 'edit'])->name('dashboard.clients.orders.edit');
                Route::post('/update/{order}/{client}', [OrderController::class, 'update'])->name('dashboard.clients.orders.update');
                Route::get('/delete/{client}', [OrderController::class, 'destroy'])->name('dashboard.clients.orders.delete');
            });
        });
        // Orders route

        Route::prefix('orders')->group(function () {

            Route::get('/index', [OrderGenralController::class, 'index'])->name('dashboard.orders.index');
            Route::get('/{order}/products', [OrderGenralController::class, 'products'])->name('dashboard.orders.products');
            Route::get('/create', [OrderGenralController::class, 'create'])->name('dashboard.orders.create');
            Route::post('/store', [OrderGenralController::class, 'store'])->name('dashboard.orders.store');
            Route::get('/edit/{order}/{client}', [OrderGenralController::class, 'edit'])->name('dashboard.orders.edit');
            Route::post('/update', [OrderGenralController::class, 'update'])->name('dashboard.orders.update');
            Route::get('/delete/{order}', [OrderGenralController::class, 'destroy'])->name('dashboard.orders.delete');
        });

    });

});
