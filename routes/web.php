<?php

use App\Http\Controllers\Painel\BookController;
use App\Http\Controllers\Painel\UserController;
use App\Http\Controllers\Painel\HomeController;
use App\Http\Controllers\Painel\OrdersController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
Route::get('/orders/detail/{id}', [OrdersController::class, 'seeDetail'])->name('orderDetail');
Route::get('/orders/changeStatus/{id}/{status}', [OrdersController::class, 'changeStatus'])->name('changeStatus');

Route::any('/addBook', [BookController::class, 'add'])->name('addBook');
Route::any('/editBook/{id}', [BookController::class, 'edit'])->name('editBook');
Route::get('/deleteBook/{id}', [BookController::class, 'delete'])->name('deleteBook');

Route::get('/my_profile', [UserController::class, 'myProfile'])->name('myProfile');
Route::get('/users', [UserController::class, 'usersSite'])->name('usersSite');
Route::get('/blockUnlock/{id}', [UserController::class, 'blockUnlock'])->name('blockUnlock');
Route::post('/update_user', [UserController::class, 'updateUser'])->name('updateUser');
