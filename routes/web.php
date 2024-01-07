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
        // Route::get('/superadmin', [App\Http\Controllers\DashboardController::class, 'superadmin'])->name('dashboard.superadmin');

        // Routing Kelola User
        Route::delete('/user/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/user/trash', [App\Http\Controllers\UserController::class, 'trash'])->name('user.trash');
        Route::get('/user/restore/{id?}', [App\Http\Controllers\UserController::class, 'restore'])->name('user.restore');
        Route::get('/user/delete/{id?}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');

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
        Route::get('peminjaman/superadmin/index', [App\Http\Controllers\PeminjamanController::class, 'index'])->name('peminjaman.superadmin.index');
        Route::get('/peminjaman/superadmin/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman.superadmin.create');
        Route::post('/peminjaman/superadmin', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.superadmin.store');
        Route::get('peminjaman/superadmin/show/{id}', [App\Http\Controllers\PeminjamanController::class, 'superadminShow'])->name('peminjaman.superadmin.show');
        Route::get('peminjaman/edit/{id}', [App\Http\Controllers\PeminjamanController::class, 'edit'])->name('peminjaman.superadmin.edit');
        Route::get('peminjaman/superadmin/riwayat', [App\Http\Controllers\PeminjamanController::class, 'riwayatPinjamSuperadmin'])->name('peminjaman.superadmin.riwayat');
        Route::get('peminjaman/superadmin/showRiwayat/{id}', [App\Http\Controllers\PeminjamanController::class, 'superadminShowRiwayat'])->name('peminjaman.superadmin.showRiwayat');
        Route::get('peminjaman/superadmin/destroy/{id}', [App\Http\Controllers\PeminjamanController::class, 'destroy'])->name('peminjaman.superadmin.destroy');
        // Route::get('peminjaman/superadmin/list', [App\Http\Controllers\PeminjamanController::class, 'showList'])->name('peminjaman.superadmin.list');

        Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class);

        // Routing Pengembalian Aset
        Route::get('pengembalian/superadmin/index', [App\Http\Controllers\PengembalianController::class, 'index'])->name('pengembalian.superadmin.index');
        Route::get('pengembalian/superadmin/create', [App\Http\Controllers\PengembalianController::class, 'create'])->name('pengembalian.superadmin.create');
        Route::post('pengembalian/superadmin', [App\Http\Controllers\PengembalianController::class, 'store'])->name('pengembalian.superadmin.store');
        Route::get('pengembalian/superadmin/show/{id}', [App\Http\Controllers\PengembalianController::class, 'superadminShow'])->name('pengembalian.superadmin.show');
        Route::get('pengembalian/edit/{id}', [App\Http\Controllers\PengembalianController::class, 'edit'])->name('pengembalian.superadmin.edit');
        Route::get('pengembalian/superadmin/riwayat', [App\Http\Controllers\PengembalianController::class, 'riwayatKembaliSuperadmin'])->name('pengembalian.superadmin.riwayat');
        Route::get('pengembalian/superadmin/showRiwayat/{id}', [App\Http\Controllers\PengembalianController::class, 'superadminShowRiwayat'])->name('pengembalian.superadmin.showRiwayat');

        Route::post('/pengembalian/set_sanksi/{id}', [App\Http\Controllers\PengembalianController::class, 'setSanksi'])->name('pengembalian.set_sanksi');

        Route::resource('pengembalian', App\Http\Controllers\PengembalianController::class)->except([
            'destroy',
        ]);

        // Routing Pembayaran Aset
        Route::get('pembayaran/superadmin/index', [App\Http\Controllers\PembayaranController::class, 'index'])->name('pembayaran.superadmin.index');
        Route::get('pembayaran/superadmin/create', [App\Http\Controllers\PembayaranController::class, 'create'])->name('pembayaran.superadmin.create');

        // Routing Kelola Laporan
        Route::get('laporan/peminjaman/superadmin/index', [App\Http\Controllers\LaporanPeminjamanController::class, 'index'])->name('laporan.peminjaman.superadmin.index');
        Route::get('laporan/pengembalian/superadmin/index', [App\Http\Controllers\LaporanPengembalianController::class, 'index'])->name('laporan.pengembalian.superadmin.index');



    });


    // Routing middleware untuk Sekda
    Route::middleware('sekda')->group(function () {
        Route::get('/dashboard/sekda', [App\Http\Controllers\DashboardController::class, 'sekda'])->name('dashboard.sekda');

        // Routing dashboard dari sidebar
        // Route::get('/sekda', [App\Http\Controllers\DashboardController::class, 'sekda'])->name('dashboard.sekda');

        // Routing Lihat Aset
        Route::get('/seeAset/sekda', [App\Http\Controllers\SeeAsetController::class, 'index'])->name('seeAset.sekda');
        Route::get('/seeAset/sekda/show/{id}', [App\Http\Controllers\SeeAsetController::class, 'show'])->name('seeAset.sekda.show');

        // Routing Peminjaman Aset
        Route::get('peminjaman/sekda/index', [App\Http\Controllers\PeminjamanController::class, 'index'])->name('peminjaman.sekda.index');
        Route::get('/peminjaman/sekda/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman.sekda.create');
        Route::post('/peminjaman/sekda', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.sekda.store');
        Route::get('peminjaman/sekda/show/{id}', [App\Http\Controllers\PeminjamanController::class, 'sekdaShow'])->name('peminjaman.sekda.show');
        Route::post('/peminjaman/{id}/verifikasi', [App\Http\Controllers\PeminjamanController::class, 'updateStatus'])->name('peminjaman.verifikasi');
        // Route::get('peminjaman/sekda/list', [App\Http\Controllers\PeminjamanController::class, 'showList'])->name('peminjaman.sekda.list');
        Route::get('peminjaman/sekda/riwayat', [App\Http\Controllers\PeminjamanController::class, 'riwayatPinjamSekda'])->name('peminjaman.sekda.riwayat');
        Route::get('peminjaman/sekda/showRiwayat/{id}', [App\Http\Controllers\PeminjamanController::class, 'sekdaShowRiwayat'])->name('peminjaman.sekda.showRiwayat');

        Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class)->except([
            'destroy',
        ]);

        // Routing Pengembalian Aset
        Route::get('pengembalian/sekda/index', [App\Http\Controllers\PengembalianController::class, 'index'])->name('pengembalian.sekda.index');
        Route::get('pengembalian/sekda/create', [App\Http\Controllers\PengembalianController::class, 'create'])->name('pengembalian.sekda.create');
        Route::post('pengembalian/sekda', [App\Http\Controllers\PengembalianController::class, 'store'])->name('pengembalian.sekda.store');
        Route::get('pengembalian/sekda/show/{id}', [App\Http\Controllers\PengembalianController::class, 'sekdaShow'])->name('pengembalian.sekda.show');
        Route::post('pengembalian/{id}/verifikasi', [App\Http\Controllers\PengembalianController::class, 'updateStatus'])->name('pengembalian.verifikasi');
        Route::get('pengembalian/sekda/riwayat', [App\Http\Controllers\PengembalianController::class, 'riwayatKembaliSekda'])->name('pengembalian.sekda.riwayat');
        Route::get('pengembalian/sekda/showRiwayat/{id}', [App\Http\Controllers\PengembalianController::class, 'sekdaShowRiwayat'])->name('pengembalian.sekda.showRiwayat');

        Route::post('/pengembalian/set_sanksi/{id}', [App\Http\Controllers\PengembalianController::class, 'setSanksi'])->name('pengembalian.set_sanksi');

        Route::resource('pengembalian', App\Http\Controllers\PengembalianController::class)->except([
            'destroy',
        ]);

        // Routing Pembayaran
        Route::get('pembayaran/sekda/index', [App\Http\Controllers\PembayaranController::class, 'index'])->name('pembayaran.sekda.create');
        Route::get('pembayaran/sekda/create', [App\Http\Controllers\PembayaranController::class, 'create'])->name('pembayaran.sekda.create');

        // Routing Laporan
        Route::get('laporan/peminjaman/sekda/index', [App\Http\Controllers\LaporanPeminjamanController::class, 'index'])->name('laporan.peminjaman.sekda.index');
        Route::get('laporan/pengembalian/sekda/index', [App\Http\Controllers\LaporanPengembalianController::class, 'index'])->name('laporan.pengembalian.sekda.index');

    });


    // Routing middleware untuk OPD
    Route::middleware('opd')->group(function () {
        Route::get('/dashboard/opd', [App\Http\Controllers\DashboardController::class, 'opd'])->name('dashboard.opd');

        // Routing dashboard dari sidebar
        // Route::get('/opd', [App\Http\Controllers\DashboardController::class, 'opd'])->name('dashboard.opd');

        // Routing Lihat Aset
        Route::get('/seeAset/opd', [App\Http\Controllers\SeeAsetController::class, 'index'])->name('seeAset.opd');
        Route::get('/seeAset/opd/show/{id}', [App\Http\Controllers\SeeAsetController::class, 'show'])->name('seeAset.opd.show');

         // Routing Peminjaman Aset
         Route::get('peminjaman/opd/index', [App\Http\Controllers\PeminjamanController::class, 'index'])->name('peminjaman.opd.index');
         Route::get('/peminjaman/opd/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman.opd.create');
         Route::post('/peminjaman/opd', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.opd.store');
         Route::get('peminjaman/opd/show/{id}', [App\Http\Controllers\PeminjamanController::class, 'opdShow'])->name('peminjaman.opd.show');
         Route::get('peminjaman/opd/riwayat', [App\Http\Controllers\PeminjamanController::class, 'riwayatPinjamOpd'])->name('peminjaman.opd.riwayat');
         Route::get('peminjaman/opd/showRiwayat/{id}', [App\Http\Controllers\PeminjamanController::class, 'opdShowRiwayat'])->name('peminjaman.opd.showRiwayat');


         Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class)->except([
             'destroy',
         ]);

         // Routing Pengembalian Aset
        Route::get('pengembalian/opd/index', [App\Http\Controllers\PengembalianController::class, 'index'])->name('pengembalian.opd.index');
        Route::get('pengembalian/opd/create', [App\Http\Controllers\PengembalianController::class, 'create'])->name('pengembalian.opd.create');
        Route::post('pengembalian/opd', [App\Http\Controllers\PengembalianController::class, 'store'])->name('pengembalian.opd.store');
        Route::get('pengembalian/opd/riwayat', [App\Http\Controllers\PengembalianController::class, 'riwayatKembaliOpd'])->name('pengembalian.opd.riwayat');
        Route::get('pengembalian/opd/showRiwayat/{id}', [App\Http\Controllers\PengembalianController::class, 'opdShowRiwayat'])->name('pengembalian.opd.showRiwayat');

        Route::resource('pengembalian', App\Http\Controllers\PengembalianController::class)->except([
            'destroy',
        ]);

        // Routing Pembayaran
        Route::get('pembayaran/opd/index', [App\Http\Controllers\PembayaranController::class, 'index'])->name('pembayaran.opd.index');
        Route::get('pembayaran/opd/create', [App\Http\Controllers\PembayaranController::class, 'create'])->name('pembayaran.opd.create');
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
