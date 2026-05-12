<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->middleware(['auth', 'verified', 'role:admin'])->name('dashboard.admin');

Route::get('/dashboard/kasir', [DashboardController::class, 'kasir'])->middleware(['auth', 'verified', 'role:kasir'])->name('dashboard.kasir');

// Fallback dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Products routes - only admin can access
Route::resource('products', ProductController::class)->middleware(['auth', 'verified', 'role:admin']);

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/stok', [StockController::class, 'index'])->name('stok.index');
    Route::patch('/stok/{product}', [StockController::class, 'update'])->name('stok.update');
});

// Transaction routes for kasir and admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/add-cart', [TransactionController::class, 'addCart'])->name('transaksi.addCart');
    Route::post('/transaksi/update-cart', [TransactionController::class, 'updateCart'])->name('transaksi.updateCart');
    Route::post('/transaksi/remove-cart', [TransactionController::class, 'removeCart'])->name('transaksi.removeCart');
    Route::post('/transaksi/checkout', [TransactionController::class, 'checkout'])->name('transaksi.checkout');
    Route::get('/transaksi/riwayat', [TransactionController::class, 'history'])->name('transaksi.history');
    Route::get('/transaksi/{transaction}', [TransactionController::class, 'show'])->name('transaksi.show');
    Route::delete('/transaksi/{transaction}', [TransactionController::class, 'destroy'])->name('transaksi.destroy');
});

// Laporan routes - only admin
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [LaporanController::class, 'detail'])->name('laporan.detail');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
    Route::get('/laporan/{id}/export/pdf', [LaporanController::class, 'exportDetailPdf'])->name('laporan.exportDetailPdf');
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    Route::delete('/laporan/clear/all-except-admin', [LaporanController::class, 'clearAllExceptAdmin'])->name('laporan.clearAllExceptAdmin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto');
});

require __DIR__.'/auth.php';
