<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperadminController;

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


// Route::group(['middleware' => ['auth', 'checkRole:1']], function () {
//     Route::get('/superadmin-dashboard', function () {
//         return view('dashboard.superadmin');
//     })->name('superadmin.dashboard');
// });

// Route::group(['middleware' => ['auth', 'checkRole:2']], function () {
//     Route::get('/sekda-dashboard', function () {
//         return view('dashboard.sekda');
//     })->name('sekda.dashboard');
// });

// Route::group(['middleware' => ['auth', 'checkRole:3']], function () {
//     Route::get('/opd-dashboard', function () {
//         return view('dashboard.opd');
//     })->name('opd.dashboard');
// });

// rangkuman dari code di atas
// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/superadmin-dashboard', function () {
//         return view('dashboard.superadmin');
//     })->name('superadmin.dashboard')->middleware('checkRole:[1]');
    
//     Route::get('/sekda-dashboard', function () {
//         return view('dashboard.sekda');
//     })->name('sekda.dashboard')->middleware('checkRole:[2]');
    
//     Route::get('/opd-dashboard', function () {
//         return view('dashboard.opd');
//     })->name('opd.dashboard')->middleware('checkRole:[3]');
// });

// Route::group(['middleware' => ['auth', 'redirectIfAuthenticated']], function () {
//     Route::get('/superadmin-dashboard', function () {
//         if (Auth::user()->role_id != 1) {
//             return redirect('/login');
//         }
//         return view('dashboard.superadmin');
//     })->name('dashboard.superadmin');

//     Route::get('/sekda-dashboard', function () {
//         if (Auth::user()->role_id != 2) {
//             return redirect('/login');
//         }
//         return view('dashboard.sekda');
//     })->name('dashboard.sekda');

//     Route::get('/opd-dashboard', function () {
//         if (Auth::user()->role_id != 3) {
//             return redirect('/login');
//         }
//         return view('dashboard.opd');
//     })->name('dashboard.opd');

//     Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// });


Route::group(['middleware' => ['auth']], function () {
    Route::get('/superadmin-dashboard', function () {
        if (Auth::user()->role_id != 1) {
            return redirect('/login');
        }
        return view('dashboard.superadmin');
    })->name('dashboard.superadmin');

    Route::get('/sekda-dashboard', function () {
        if (Auth::user()->role_id != 2) {
            return redirect('/login');
        }
        return view('dashboard.sekda');
    })->name('dashboard.sekda');

    Route::get('/opd-dashboard', function () {
        if (Auth::user()->role_id != 3) {
            return redirect('/login');
        }
        return view('dashboard.opd');
    })->name('dashboard.opd');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');



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