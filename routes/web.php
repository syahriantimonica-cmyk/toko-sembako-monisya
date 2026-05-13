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

// Redirect awal ke login
Route::get('/', function () {
    return redirect('/login');
});

// =====================
// DASHBOARD
// =====================

// Dashboard admin
Route::get('/dashboard/admin', function () {
    return 'Dashboard Admin Berhasil';
})->middleware(['auth'])->name('dashboard.admin');

// Dashboard kasir
Route::get('/dashboard/kasir', function () {
    return 'Dashboard Kasir Berhasil';
})->middleware(['auth'])->name('dashboard.kasir');

// Dashboard umum
Route::get('/dashboard', function () {
    return 'Dashboard Berhasil Login';
})->middleware(['auth'])->name('dashboard');


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

    Route::get('/stok', [StockController::class, 'index'])->name('stok.index');

    Route::patch('/stok/{product}', [StockController::class, 'update'])->name('stok.update');

});


// =====================
// TRANSAKSI
// =====================

Route::middleware(['auth'])->group(function () {

    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');

    Route::post('/transaksi/add-cart', [TransactionController::class, 'addCart'])->name('transaksi.addCart');

    Route::post('/transaksi/update-cart', [TransactionController::class, 'updateCart'])->name('transaksi.updateCart');

    Route::post('/transaksi/remove-cart', [TransactionController::class, 'removeCart'])->name('transaksi.removeCart');

    Route::post('/transaksi/checkout', [TransactionController::class, 'checkout'])->name('transaksi.checkout');

    Route::get('/transaksi/riwayat', [TransactionController::class, 'history'])->name('transaksi.history');

    Route::get('/transaksi/{transaction}', [TransactionController::class, 'show'])->name('transaksi.show');

    Route::delete('/transaksi/{transaction}', [TransactionController::class, 'destroy'])->name('transaksi.destroy');

});


// =====================
// LAPORAN
// =====================

Route::middleware(['auth'])->group(function () {

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    Route::get('/laporan/{id}', [LaporanController::class, 'detail'])->name('laporan.detail');

    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');

    Route::get('/laporan/{id}/export/pdf', [LaporanController::class, 'exportDetailPdf'])->name('laporan.exportDetailPdf');

    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

});


// =====================
// PROFILE
// =====================

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto');

});


// =====================
// AUTH
// =====================

require __DIR__.'/auth.php';