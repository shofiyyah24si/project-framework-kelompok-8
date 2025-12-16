<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KejadianController;
use App\Http\Controllers\PoskoController;
use App\Http\Controllers\DonasiBencanaController;
use App\Http\Controllers\LogistikBencanaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// TAMBAHKAN BARIS INI:
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::view('/', 'landing')->name('landing');

// ROUTE LOGIN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| APPLICATION ROUTES (Dengan Pembatasan Akses)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // =============================================
    // ROUTE UNTUK SEMUA USER (ADMIN & WARGA)
    // =============================================
    
    // DASHBOARD - bisa diakses admin & warga
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // PROFILE ROUTES - bisa diakses admin & warga
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/avatar/update', [ProfileController::class, 'updateAvatar'])
            ->name('profile.avatar.update');
        Route::delete('/avatar/delete', [ProfileController::class, 'deleteAvatar'])
            ->name('profile.avatar.delete');
        Route::post('/update', [ProfileController::class, 'updateProfile'])
            ->name('profile.update');
    });
    
    // =============================================
    // ROUTE KHUSUS ADMIN SAJA
    // =============================================
    // GANTI INI:
    // Route::middleware('admin')->group(function () {
    // MENJADI INI:
    Route::middleware([AdminMiddleware::class])->group(function () {
        // RESTful CRUD Routes - hanya untuk admin
        Route::resource('kejadian', KejadianController::class);
        Route::resource('posko', PoskoController::class);
        Route::resource('donasi', DonasiBencanaController::class);
        Route::resource('logistik', LogistikBencanaController::class);
        
        // Additional custom routes - hanya untuk admin
        Route::delete('/kejadian/file/{id}', [KejadianController::class, 'deleteFile'])
            ->name('kejadian.deleteFile');
        
        Route::post('/logistik/{id}/reduce-stock', [LogistikBencanaController::class, 'reduceStock'])
            ->name('logistik.reduce-stock');
    });
});

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE (404)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('landing');
});