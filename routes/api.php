<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ClientController;
use App\Http\Controllers\api\DashboardController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\LogoutController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\OrderGenralController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [LoginController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/index', [DashboardController::class, 'index']);
    Route::post('users/{user}', [UserController::class, 'update']);
    Route::apiResource('users', UserController::class)->except('show', 'update');
    Route::apiResource('clients', ClientController::class)->except('show');
    Route::apiResource('categories', CategoryController::class)->except('show');
    Route::apiResource('products', ProductController::class)->except('show');
    Route::apiResource('orders', OrderGenralController::class)->except('store', 'update');
    Route::apiResource('clients.orders', OrderController::class)->except('index', 'show', 'destroy');
    Route::post('/logout', [LogoutController::class, 'logout']);
});
