<?php

use App\Http\Controllers\CetakController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\DataKendaraanController;
use App\Http\Controllers\StokParkirController;
use App\Http\Controllers\TransaksiParkirController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Auth::routes();

// Dashboard setelah login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Coba lihat layout admin
Route::get('/lihat', function () {
    return view('layouts.admin');
});

Route::resource('stok-parkir', StokParkirController::class);

// Kendaraan CRUD
Route::resource('/kendaraan', DataKendaraanController::class);

// ---------------------- PARKIR ---------------------- //

// Lihat data parkir
Route::get('/parkir', [ParkirController::class, 'index'])->name('parkir.index');

// Form masukin kendaraan
Route::get('/parkir/form', function () {
    return view('petugas.parkir.create');
})->name('parkir.form');

// Simpan data kendaraan masuk
Route::post('/parkir/store', [ParkirController::class, 'create'])->name('parkir.store');

// Cetak tiket masuk
Route::get('/parkir/tiket/{id}', [ParkirController::class, 'tiketMasuk'])->name('parkir.tiketMasuk');

// ---------------------- TRANSAKSI ---------------------- //

// Autocomplete plat nomor (buat form)
Route::get('/autocomplete-plat', [TransaksiParkirController::class, 'autocompletePlat'])->name('autocomplete.plat');

// Form kendaraan keluar
Route::get('/kendaraan-keluar/form', function () {
    return view('petugas.transaksi.create');
})->name('kendaraanKeluar.form');

// Proses kendaraan keluar
Route::post('/kendaraan-keluar', [TransaksiParkirController::class, 'kendaraanKeluar'])->name('kendaraan.keluar');

// Tampilkan form kompensasi (jika ada denda)
Route::get('/transaksi/kompensasi/{id}/create', [TransaksiParkirController::class, 'create'])->name('transaksi.kompensasi.create');

// (Cadangan) Form kompensasi
Route::get('/kompensasi/form', function () {
    return view('petugas.transaksi.create');
})->name('kompensasi.form');

// // (Cadangan) Tampilan transaksi
// Route::get('/transaksi/form', function () {
//     return view('petugas.transaksi.transaksi');
// })->name('transaksi.index');

// Tampilkan detail pembayaran
Route::get('/pembayaran/{id}', [TransaksiParkirController::class, 'show'])->name('pembayaran.show');
Route::get('/transaksi/buat/{id}', [TransaksiParkirController::class, 'buatTransaksi'])->name('transaksi.buat');
Route::post('/transaksi/simpan', [TransaksiParkirController::class, 'prosesTransaksi'])->name('transaksi.simpan');
Route::get('/transaksi', [TransaksiParkirController::class, 'index'])->name('admin.transaksi.index');

// cetak tiket
Route::get('/transaksi/tiket/{id}/pdf', [CetakController::class, 'cetakTiket'])->name('transaksi.tiket.pdf');
Route::get('/transaksi/struk/{id}/pdf', [CetakController::class, 'cetakStruk'])->name('transaksi.struk.pdf');

