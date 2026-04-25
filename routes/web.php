<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriObatController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\ApotikController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\StockMutationController;
use App\Http\Controllers\ExpiredMedicineController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ReturnPembelianController;
use App\Http\Controllers\ReturnPenjualanController;
use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\CashierClosingController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Master Data Routes
    Route::resource('users', UserController::class);
    Route::resource('kategori-obat', KategoriObatController::class);
    Route::resource('satuan', SatuanController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('pelanggan', CustomerController::class);
    Route::resource('stok-obat', App\Http\Controllers\StokObatController::class);
    Route::resource('stok-opname', StokOpnameController::class);
    Route::get('/mutasi-stok', [StockMutationController::class, 'index'])->name('mutasi-stok.index');
    Route::get('/obat-expired', [ExpiredMedicineController::class, 'index'])->name('obat-expired.index');

    // Transaksi Routes
    Route::resource('pembelian', PembelianController::class)->except(['edit','update']);
    Route::resource('penjualan', PenjualanController::class)->except(['edit','update']);
    Route::resource('return-pembelian', ReturnPembelianController::class)->except(['edit','update']);
    Route::resource('return-penjualan', ReturnPenjualanController::class)->except(['edit', 'update']);

    // Kasir Routes
    Route::get('/kas-masuk', [CashTransactionController::class, 'kasMasukIndex'])->name('kas-masuk.index');
    Route::get('/kas-masuk/create', [CashTransactionController::class, 'kasMasukCreate'])->name('kas-masuk.create');
    Route::post('/kas-masuk', [CashTransactionController::class, 'kasMasukStore'])->name('kas-masuk.store');

    Route::get('/kas-keluar', [CashTransactionController::class, 'kasKeluarIndex'])->name('kas-keluar.index');
    Route::get('/kas-keluar/create', [CashTransactionController::class, 'kasKeluarCreate'])->name('kas-keluar.create');
    Route::post('/kas-keluar', [CashTransactionController::class, 'kasKeluarStore'])->name('kas-keluar.store');
    Route::get('/kas-keluar/{id}', [CashTransactionController::class, 'kasKeluarShow'])->name('kas-keluar.show');
    Route::get('/kas-keluar/{id}/print', [CashTransactionController::class, 'kasKeluarPrint'])->name('kas-keluar.print');

    // Tutup Kasir Routes
    Route::resource('tutup-kasir', CashierClosingController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/tutup-kasir/{id}/print', [CashierClosingController::class, 'show'])->name('tutup-kasir.print');

    // Pengaturan Routes
    Route::get('/profil-apotek', [ApotikController::class, 'index'])->name('profil-apotek.index');
    Route::post('/profil-apotek', [ApotikController::class, 'update'])->name('profil-apotek.update');
});
