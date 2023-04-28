<?php

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::any('/addBook', [App\Http\Controllers\BookController::class, 'add'])->name('addBook');
Route::any('/editBook/{id}', [App\Http\Controllers\BookController::class, 'edit'])->name('editBook');
Route::get('/deleteBook/{id}', [App\Http\Controllers\BookController::class, 'delete'])->name('deleteBook');
Route::get('/my_profile', [App\Http\Controllers\UserController::class, 'myProfile'])->name('myProfile');
Route::post('/update_user', [App\Http\Controllers\UserController::class, 'updateUser'])->name('updateUser');

Route::get('/foo', function () {
    Artisan::call('storage:link');
});