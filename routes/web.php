<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/ketua', function () {
    return view('ketua');
});

Route::get('/angggota', function () {
    return view('anggota');
});

Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

<<<<<<< HEAD
Route::resource('warga',WargaController::class);
=======
Route::resource('warga', WargaController::class);
Route::resource('products', \App\Http\Controllers\ProductController::class);
>>>>>>> 9f485e18020f5ea0016bdb032c4f18d54946509b
