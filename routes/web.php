<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AsetController as AdminAset;
use App\Http\Controllers\Admin\KategoriController as AdminKategori;
use App\Http\Controllers\Admin\LokasiController as AdminLokasi;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksi;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\AsetController as UserAset;
use App\Http\Controllers\User\TransaksiController as UserTransaksi;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Aset
        Route::resource('aset', AdminAset::class);

        // Kategori
        Route::resource('kategori', AdminKategori::class)->except(['show']);

        // Lokasi
        Route::resource('lokasi', AdminLokasi::class)->except(['show']);

        // Transaksi
        Route::get('/transaksi', [AdminTransaksi::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/create', [AdminTransaksi::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [AdminTransaksi::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/{transaksi}', [AdminTransaksi::class, 'show'])->name('transaksi.show');
        Route::patch('/transaksi/{transaksi}/kembalikan', [AdminTransaksi::class, 'kembalikan'])->name('transaksi.kembalikan');

        // Laporan
        Route::get('/laporan', [AdminLaporan::class, 'index'])->name('laporan.index');

        // Manajemen User
        Route::resource('user', AdminUser::class)->except(['show']);
    });

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', 'role:user'])
    ->group(function () {

        Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');

        // Aset (read-only)
        Route::get('/aset', [UserAset::class, 'index'])->name('aset.index');
        Route::get('/aset/{aset}', [UserAset::class, 'show'])->name('aset.show');

        // Transaksi
        Route::get('/transaksi', [UserTransaksi::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/create', [UserTransaksi::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [UserTransaksi::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/{transaksi}', [UserTransaksi::class, 'show'])->name('transaksi.show');
    });