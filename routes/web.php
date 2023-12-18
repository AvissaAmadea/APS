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

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Routing middleware untuk Superadmin
    Route::middleware('superadmin')->group(function () {
        Route::get('/dashboard/superadmin', [App\Http\Controllers\DashboardController::class, 'superadmin'])->name('dashboard.superadmin');

        // Routing dashboard dari sidebar
        Route::get('/superadmin', [App\Http\Controllers\DashboardController::class, 'superadmin'])->name('dashboard.superadmin');

        // Routing Kelola User
        Route::delete('/user/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('user/destroy');
        Route::get('/user/trash', [App\Http\Controllers\UserController::class, 'trash'])->name('user/trash');
        Route::get('/user/restore/{id?}', [App\Http\Controllers\UserController::class, 'restore'])->name('user/restore');
        Route::get('/user/delete/{id?}', [App\Http\Controllers\UserController::class, 'delete'])->name('user/delete');

        Route::resource('user', App\Http\Controllers\UserController::class)->except([
            'destroy', 'trash', 'restore', 'delete'
        ]);

        // Routing Kelola Kategori
        Route::delete('/kategori/{id}/delete', [App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori/destroy');

        Route::resource('kategori', App\Http\Controllers\KategoriController::class)->except([
            'show'
        ]);

        // Routing Kelola Aset
        Route::delete('/aset/{id}/delete', [App\Http\Controllers\AsetController::class, 'destroy'])->name('aset/destroy');

        Route::resource('aset', App\Http\Controllers\AsetController::class);

        // Routing Peminjaman Aset
        Route::get('/peminjaman/superadmin', [App\Http\Controllers\PeminjamanController::class, 'index'])->name('peminjaman/superadmin');
        Route::get('/peminjaman/superadmin/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman.superadmin.create');
        Route::post('/peminjaman/superadmin', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.superadmin');

        Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class)->except([
            'show',
        ]);
    });


    // Routing middleware untuk Sekda
    Route::middleware('sekda')->group(function () {
        Route::get('/dashboard/sekda', [App\Http\Controllers\DashboardController::class, 'sekda'])->name('dashboard.sekda');

        // Routing dashboard dari sidebar
        Route::get('/sekda', [App\Http\Controllers\DashboardController::class, 'sekda'])->name('dashboard.sekda');

        // Routing Lihat Aset
        Route::get('/seeAset/sekda/', [App\Http\Controllers\SeeAsetController::class, 'index'])->name('seeAset/sekda');
        Route::get('/seeAset/sekda/show/{id}', [App\Http\Controllers\SeeAsetController::class, 'show'])->name('seeAset/sekda/show');

         // Routing Peminjaman Aset
         Route::get('/peminjaman/sekda', [App\Http\Controllers\AsetController::class, 'index'])->name('peminjaman/sekda');
         Route::get('/peminjaman/sekda/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman/sekda/create');
         Route::post('/peminjaman/sekda', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman/sekda');

         Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class)->except([
             'show',
         ]);
    });


    // Routing middleware untuk OPD
    Route::middleware('opd')->group(function () {
        Route::get('/dashboard/opd', [App\Http\Controllers\DashboardController::class, 'opd'])->name('dashboard.opd');

        // Routing dashboard dari sidebar
        Route::get('/opd', [App\Http\Controllers\DashboardController::class, 'opd'])->name('dashboard.opd');

        // Routing Lihat Aset
        Route::get('/seeAset/opd/', [App\Http\Controllers\SeeAsetController::class, 'index'])->name('seeAset/opd');
        Route::get('/seeAset/opd/show/{id}', [App\Http\Controllers\SeeAsetController::class, 'show'])->name('seeAset/opd/show');

         // Routing Peminjaman Aset
         Route::get('/peminjaman/opd', [App\Http\Controllers\AsetController::class, 'index'])->name('peminjaman/opd');
         Route::get('/peminjaman/opd/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman/opd/create');
         Route::post('/peminjaman/opd', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman/opd');

         Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class)->except([
             'show',
         ]);
    });
});


Auth::routes();

// Routing Kelola User
    // Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
    // Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user/create');
    // Route::post('/user', [App\Http\Controllers\UserController::class, 'store'])->name('store');
    // Route::get('/user/show/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user/show');
    // Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user/edit');
    // Route::delete('/user/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('user/destroy');
    // Route::get('/user/trash', [App\Http\Controllers\UserController::class, 'trash'])->name('user/trash');
    // Route::get('/user/restore/{id?}', [App\Http\Controllers\UserController::class, 'restore'])->name('user/restore');
    // Route::get('/user/delete/{id?}', [App\Http\Controllers\UserController::class, 'delete'])->name('user/delete');

// Routing Kelola Kategori
    // Route::get('/kategori', [App\Http\Controllers\KategoriController::class, 'index'])->name('kategori');
    // Route::get('/kategori/create', [App\Http\Controllers\KategoriController::class, 'create'])->name('kategori/create');
    // Route::post('/kategori', [App\Http\Controllers\KategoriController::class, 'store'])->name('store');
    // Route::get('/kategori/show/{id}', [App\Http\Controllers\KategoriController::class, 'show'])->name('kategori/show');
    // Route::get('/kategori/edit/{id}', [App\Http\Controllers\KategoriController::class, 'edit'])->name('kategori/edit');
    // Route::delete('/kategori/{id}/delete', [App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori/destroy');

// Routing Kelola Aset
    // Route::get('/aset', [App\Http\Controllers\AsetController::class, 'index'])->name('aset');
    // Route::get('/aset/create', [App\Http\Controllers\AsetController::class, 'create'])->name('user/create');
    // Route::post('/aset', [App\Http\Controllers\AsetController::class, 'store'])->name('store');
    // Route::get('/aset/show/{id}', [App\Http\Controllers\AsetController::class, 'show'])->name('aset/show');
    // Route::get('/aset/edit/{id}', [App\Http\Controllers\AsetController::class, 'edit'])->name('aset/edit');
    // Route::delete('/aset/{id}/delete', [App\Http\Controllers\AsetController::class, 'destroy'])->name('aset/destroy');

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);

//     // Routing dashboard dari sidebar
//     Route::get('/superadmin', [App\Http\Controllers\DashboardController::class, 'superadmin'])->name('dashboard.superadmin');
//     Route::get('/sekda', [App\Http\Controllers\DashboardController::class, 'sekda'])->name('dashboard.sekda');
//     Route::get('/opd', [App\Http\Controllers\DashboardController::class, 'opd'])->name('dashboard.opd');

//     // Routing Kelola User
//     Route::delete('/user/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('user/destroy');
//     Route::get('/user/trash', [App\Http\Controllers\UserController::class, 'trash'])->name('user/trash');
//     Route::get('/user/restore/{id?}', [App\Http\Controllers\UserController::class, 'restore'])->name('user/restore');
//     Route::get('/user/delete/{id?}', [App\Http\Controllers\UserController::class, 'delete'])->name('user/delete');

//     Route::resource('user', App\Http\Controllers\UserController::class)->except([
//         'destroy', 'trash', 'restore', 'delete'
//     ]);

//     // Routing Kelola Kategori
//     Route::delete('/kategori/{id}/delete', [App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori/destroy');

//     Route::resource('kategori', App\Http\Controllers\KategoriController::class)->except([
//         'show'
//     ]);

//     // Routing Kelola Aset
//     Route::delete('/aset/{id}/delete', [App\Http\Controllers\AsetController::class, 'destroy'])->name('aset/destroy');

//     Route::resource('aset', App\Http\Controllers\AsetController::class);

//     // Routing Peminjaman Aset
//     Route::get('/peminjaman/superadmin/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman/superadmin/create');
//     Route::post('/peminjaman/superadin', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('store');

//     Route::resource('user', App\Http\Controllers\UserController::class)->except([
//         'index','show',
//     ]);

// });
