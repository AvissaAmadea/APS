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