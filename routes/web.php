<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;

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

Route::resource('warga', WargaController::class);
Route::resource('products', \App\Http\Controllers\ProductController::class);
