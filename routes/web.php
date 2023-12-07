<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

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
    return view('auth/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
// });

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
    Route::resource('user', App\Http\Controllers\UserController::class);
});

Auth::routes();

// Routing Kelola User
// Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
// Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user/create');
// Route::post('/user', [App\Http\Controllers\UserController::class, 'store'])->name('store');
// Route::get('/user/show/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user/show');
// Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user/edit');
// Route::patch('/user/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user/update');
// Route::delete('/user/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user/delete');

// Route::resource('/user', App\Http\Controllers\UserController::class);
