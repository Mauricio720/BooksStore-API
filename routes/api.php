<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/books/{search?}', [App\Http\Controllers\Api\BookController::class, 'list']);

Route::controller(AuthController::class)->group(function () {
  Route::post('logged', 'logged');
  Route::post('login', 'login');
  Route::post('user', 'register');
  Route::post('logout', 'logout');
  Route::post('refresh', 'refresh');
});


Route::controller(UserController::class)->group(function () {
  Route::put('user', 'update');
});

Route::controller(OrdersController::class)->group(function () {
  Route::post('orders', 'add');
  Route::get('orders', 'list');
  Route::post('orders/cancel/{id}', 'cancel');
});