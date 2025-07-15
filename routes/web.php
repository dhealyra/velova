<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\KompensasiController;
use App\Http\Controllers\DataKendaraanController;
use App\Http\Controllers\StokParkirController;
use App\Http\Controllers\TransaksiParkirController;
use App\Http\Middleware\RoleMiddleware;

// ==================== LANDING ====================
Route::get('/', function () {
    return view('welcome');
});

// ==================== AUTH ====================
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ==================== ADMIN ONLY ====================
Route::middleware(['auth', RoleMiddleware::class.':1'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('stok-parkir', StokParkirController::class);
    Route::get('stok-parkir/export/pdf', [CetakController::class, 'stokParkirPdf'])->name('stok-parkir.export.pdf');
    Route::get('stok-parkir/export/excel', [CetakController::class, 'stokParkirExcel'])->name('stok-parkir.export.excel');

    Route::resource('kendaraan', DataKendaraanController::class);
    Route::get('kendaraan/export/pdf', [CetakController::class, 'exportKendaraanPdf'])->name('kendaraan.export.pdf');
    Route::get('kendaraan/export/excel', [CetakController::class, 'exportKendaraanExcel'])->name('kendaraan.export.excel');

    Route::post('kompensasi/setujui/{id}', [KompensasiController::class, 'setujui'])->name('kompensasi.setujui');
    Route::post('kompensasi/tolak/{id}', [KompensasiController::class, 'tolak'])->name('kompensasi.tolak');
});

// ==================== ADMIN & PETUGAS ====================
Route::middleware(['auth', RoleMiddleware::class.':0,1'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/transaksi', [TransaksiParkirController::class, 'index'])->name('transaksi.index');
});

// ==================== PARKIR (PETUGAS) ====================
Route::middleware(['auth', RoleMiddleware::class.':0,1'])->group(function () {
    Route::get('/parkir', [ParkirController::class, 'index'])->name('parkir.index');
    Route::get('/parkir/form', fn() => view('petugas.parkir.create'))->name('parkir.form');
    Route::post('/parkir/store', [ParkirController::class, 'create'])->name('parkir.store');
    Route::get('/parkir/tiket/{id}', [ParkirController::class, 'tiketMasuk'])->name('parkir.tiketMasuk');
    Route::get('/transaksi/tiket/{id}/pdf', [CetakController::class, 'cetakTiket'])->name('transaksi.tiket.pdf');
    Route::get('/parkir/{id}/edit', [ParkirController::class, 'edit'])->name('parkir.edit');
    Route::put('/parkir/{id}', [ParkirController::class, 'update'])->name('parkir.update');
    Route::delete('/parkir/{id}', [ParkirController::class, 'destroy'])->name('parkir.destroy');
    Route::get('/kendaraanmasuk/export/pdf', [CetakController::class, 'exportKendaraanMasukPdf'])->name('kendaraanmasuk.export.pdf');
    Route::get('/kendaraanmasuk/export/excel', [CetakController::class, 'exportKendaraanMasukExcel'])->name('kendaraanmasuk.export.excel');
});

// ==================== TRANSAKSI (PETUGAS & ADMIN) ====================
Route::middleware(['auth', RoleMiddleware::class.':0,1'])->group(function () {
    Route::get('/kendaraan-keluar', [TransaksiParkirController::class, 'keluarIndex'])->name('kendaraanKeluar.index');
    Route::get('/autocomplete-plat', [TransaksiParkirController::class, 'autocompletePlat'])->name('autocomplete.plat');
    Route::get('/kendaraan-keluar/form', fn() => view('petugas.transaksi.create'))->name('kendaraanKeluar.form');
    Route::post('/kendaraan-keluar/save', [TransaksiParkirController::class, 'kendaraanKeluar'])->name('kendaraan.keluar');
    Route::get('/kendaraan-keluar/export/pdf', [CetakController::class, 'exportKendaraanKeluarPDF'])->name('kendaraankeluar.export.pdf');
    Route::get('/kendaraan-keluar/export/excel', [CetakController::class, 'exportKendaraanKeluarExcel'])->name('kendaraankeluar.export.excel');

    Route::get('/transaksi', [TransaksiParkirController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/form', fn() => view('petugas.transaksi.transaksi'))->name('transaksi.form');
    Route::get('/transaksi/{id}', [TransaksiParkirController::class, 'show'])->name('pembayaran.show');
    Route::get('/transaksi/buat/{id}', [TransaksiParkirController::class, 'buatTransaksi'])->name('transaksi.buat');
    Route::post('/transaksi/simpan', [TransaksiParkirController::class, 'prosesTransaksi'])->name('transaksi.simpan');
    Route::get('/transaksi/struk/{id}/pdf', [CetakController::class, 'cetakStruk'])->name('transaksi.struk.pdf');

    Route::get('/transaksi/export/pdf', [CetakController::class, 'exportKeuanganPDF'])->name('keuangan.export.pdf');
    Route::get('/transaksi/export/excel', [CetakController::class, 'exportKeuanganExcel'])->name('keuangan.export.excel');
});

// ==================== KOMPENSASI (PETUGAS & ADMIN) ====================
Route::middleware(['auth', RoleMiddleware::class.':0,1'])->prefix('kompensasi')->name('kompensasi.')->group(function () {
    Route::get('/', [KompensasiController::class, 'index'])->name('index');
    Route::get('/form/{idKeluar}', [KompensasiController::class, 'form'])->name('form');
    Route::post('/simpan', [KompensasiController::class, 'simpan'])->name('simpan');
    Route::get('/edit/{id}', [KompensasiController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [KompensasiController::class, 'update'])->name('update');
    Route::delete('/hapus/{id}', [KompensasiController::class, 'destroy'])->name('hapus');
    Route::get('/kompensasi/export/pdf', [CetakController::class, 'exportKompensasiPDF'])->name('kompensasi.export.pdf');
});
