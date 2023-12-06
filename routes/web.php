<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
});

Auth::routes();

Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user/create');
Route::post('/user', [App\Http\Controllers\UserController::class, 'createProcess'])->name('createProcess');
Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user/edit');

Route::get('/createUser', function () { return view('createUser'); });
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
