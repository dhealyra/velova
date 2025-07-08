<?php

use App\Http\Controllers\DataKendaraanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/lihat', function() {
    return view('layouts.admin');
});

Route::resource('/kendaraan', DataKendaraanController::class);
