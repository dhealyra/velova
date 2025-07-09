<?php

use App\Http\Controllers\DataKendaraanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParkirController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/lihat', function() {
    return view('layouts.admin');
});

Route::resource('/kendaraan', DataKendaraanController::class);

// all
Route::get('/parkir', [ParkirController::class, 'index'])->name('parkir.index');
Route::get('/parkir/form', function () {
    return view('petugas.parkir.create');
})->name('parkir.form');
Route::post('/parkir/store', [ParkirController::class, 'create'])->name('parkir.store');

