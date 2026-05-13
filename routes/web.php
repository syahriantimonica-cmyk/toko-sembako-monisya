<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================
// REDIRECT AWAL
// =====================

Route::get('/', function () {
    return redirect('/login');
});


// =====================
// DASHBOARD
// =====================

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');

    Route::get('/dashboard/kasir', [DashboardController::class, 'kasir'])
        ->name('dashboard.kasir');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});


// =====================
// PRODUCTS
// =====================

Route::middleware(['auth'])->group(function () {

    Route::resource('products', ProductController::class);
});


// =====================
// STOK
// =====================

Route::middleware(['auth'])->group(function () {

    Route::get('/stok', [StockController::class, 'index'])
        ->name('stok.index');

    Route::patch('/stok/{product}', [StockController::class, 'update'])
        ->name('stok.update');
});


// =====================
// TRANSAKSI
// =====================

Route::middleware(['auth'])->group(function () {

    Route::get('/transaksi', [TransactionController::class, 'index'])
        ->name('transaksi.index');

    Route::post('/transaksi/add-cart', [TransactionController::class, 'addCart'])
        ->name('transaksi.addCart');

    Route::post('/transaksi/update-cart', [TransactionController::class, 'updateCart'])
        ->name('transaksi.updateCart');

    Route::post('/transaksi/remove-cart', [TransactionController::class, 'removeCart'])
        ->name('transaksi.removeCart');

    Route::post('/transaksi/checkout', [TransactionController::class, 'checkout'])
        ->name('transaksi.checkout');

    Route::get('/transaksi/riwayat', [TransactionController::class, 'history'])
        ->name('transaksi.history');

    Route::get('/transaksi/{transaction}', [TransactionController::class, 'show'])
        ->name('transaksi.show');

    Route::delete('/transaksi/{transaction}', [TransactionController::class, 'destroy'])
        ->name('transaksi.destroy');
});


// =====================
// LAPORAN
// =====================

Route::middleware(['auth'])->group(function () {

    // Export PDF Semua
    Route::get(
        '/laporan/export/pdf',
        [LaporanController::class, 'exportPdf']
    )->name('laporan.exportPdf');


    // Export PDF Detail
    Route::get(
        '/laporan/{id}/export/pdf',
        [LaporanController::class, 'exportDetailPdf']
    )->name('laporan.exportDetailPdf');


    // Hapus Semua Kecuali Admin
    Route::delete(
        '/laporan/clear/all',
        [LaporanController::class, 'clearAllExceptAdmin']
    )->name('laporan.clearAllExceptAdmin');


    // Halaman Laporan
    Route::get(
        '/laporan',
        [LaporanController::class, 'index']
    )->name('laporan.index');


    // Detail Laporan
    Route::get(
        '/laporan/{id}',
        [LaporanController::class, 'detail']
    )->name('laporan.detail');


    // Hapus Transaksi
    Route::delete(
        '/laporan/{id}',
        [LaporanController::class, 'destroy']
    )->name('laporan.destroy');
});


// =====================
// PROFILE
// =====================

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])
        ->name('profile.deletePhoto');
});


// =====================
// AUTH
// =====================

require __DIR__.'/auth.php';