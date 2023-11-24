<?php

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
    return view('auth/login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/sidebarAdmin', function () { return view('sidebarAdmin'); });
Route::get('/dashboardAdmin', function () { return view('dashboardAdmin'); });
Route::get('/dashboardSekda', function () { return view('dashboardSekda'); });
Route::get('/dashboardOpd', function () { return view('dashboardOpd'); });