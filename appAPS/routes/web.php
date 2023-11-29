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

// Login Routes
Route::get('/login', 'LoginController@showLoginForm')->name('login');
Route::post('/login', 'LoginController@login')->name('login.submit');

// Registration Routes
Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'RegisterController@register')->name('register.submit');

// Common Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard Routes for each role
    Route::get('/dashboard',function () {
        return view('superadmin');
    })->name('superadmin.dashboard')->middleware('role:1'); // 1 for superadmin

    Route::get('/dashboard',function () {
        return view('sekda');
    })->name('sekda.dashboard')->middleware('role:2'); // 2 for sekda

    Route::get('/dashboard',function () {
        return view('opd');
    })->name('opd.dashboard')->middleware('role:3'); // 3 for opd
});

Route::get('/dashboard', 'SuperadminController@dashboard')->middleware('superadmin.dashboard');
Route::get('/dashboard', 'SekdaController@dashboard')->middleware('sekda.dashboard');
Route::get('/dashboard', 'OpdController@dashboard')->middleware('opd.dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboardAdmin', function () { return view('dashboardAdmin'); });
Route::get('/dashboardSekda', function () { return view('dashboardSekda'); });
Route::get('/dashboardOpd', function () { return view('dashboardOpd'); });

Route::get('/kategori', function () { return view('kategori'); });
Route::get('/inputKategori', function () { return view('inputKategori'); });

Route::get('/aset', function () { return view('aset'); });
Route::get('/inputAset', function () { return view('inputAset'); });
Route::get('/lihatAset', function () { return view('lihatAset'); });

Route::get('/user', function () { return view('user'); });
Route::get('/inputUser', function () { return view('inputUser'); });