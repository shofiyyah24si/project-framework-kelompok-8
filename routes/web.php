<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KejadianController;
use App\Http\Controllers\PoskoController;
use App\Http\Controllers\DonasiBencanaController;
use App\Http\Controllers\LogistikBencanaController;
use App\Http\Controllers\DistribusiLogistikController;
use App\Http\Controllers\WargaController;

// LANDING PAGE
Route::view('/', 'landing')->name('landing');

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/api/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');

// SEMUA DATA READ-ONLY DALAM GROUP
Route::prefix('data')->group(function () {
    // Kejadian Bencana
    Route::get('/kejadian', [KejadianController::class, 'index'])->name('kejadian.index');
    Route::get('/kejadian/{id}', [KejadianController::class, 'show'])->name('kejadian.show');
    
    // Posko Darurat
    Route::get('/posko', [PoskoController::class, 'index'])->name('posko.index');
    Route::get('/posko/{id}', [PoskoController::class, 'show'])->name('posko.show');
    
    // Donasi
    Route::get('/donasi', [DonasiBencanaController::class, 'index'])->name('donasi.index');
    Route::get('/donasi/{id}', [DonasiBencanaController::class, 'show'])->name('donasi.show');
    
    // Logistik
    Route::get('/logistik', [LogistikBencanaController::class, 'index'])->name('logistik.index');
    Route::get('/logistik/{id}', [LogistikBencanaController::class, 'show'])->name('logistik.show');
    
    // Distribusi Logistik
    Route::get('/distribusi', [DistribusiLogistikController::class, 'index'])->name('distribusi.index');
    Route::get('/distribusi/{id}', [DistribusiLogistikController::class, 'show'])->name('distribusi.show');
    
    // Warga
    Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
    Route::get('/warga/{id}', [WargaController::class, 'show'])->name('warga.show');
});

// FALLBACK
Route::fallback(function () {
    return redirect()->route('dashboard');
});