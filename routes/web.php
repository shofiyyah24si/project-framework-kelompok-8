<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KejadianBencanaController;

Route::get('/', function () {
    return view('template'); // tampilkan landing page guest
});

// Route lain
Route::get('/login', fn() => view('login'))->name('login');
Route::get('/ketua', fn() => view('ketua'));
Route::get('/anggota', fn() => view('anggota'));

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// CRUD Warga
Route::resource('warga', WargaController::class);

// CRUD Kejadian Bencana
Route::resource('kejadian-bencana', KejadianBencanaController::class);

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Group admin (kalau nanti mau ditambahkan dashboard admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
});
