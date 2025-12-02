<?php

use Illuminate\Support\Facades\Route;

// ===== IMPORT CONTROLLERS =====
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\IncidentController;

use App\Http\Controllers\WargaController;
use App\Http\Controllers\KejadianController;
use App\Http\Controllers\PoskoController;


/*
|--------------------------------------------------------------------------
| AUTH – USER TIDAK PERLU LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES – HARUS LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // HOME
    Route::get('/', fn() => view('home'))->name('home');

    // STATIC PAGES
    Route::get('/ketua', fn() => view('ketua'));
    Route::get('/anggota', fn() => view('anggota'));

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kejadian/{id}/detail', [KejadianController::class, 'show'])->name('kejadian.show');

    // CRUD RESOURCES
    Route::resource('warga', WargaController::class)->except(['show']);
    Route::resource('kejadian', KejadianController::class);
    Route::resource('posko', PoskoController::class);

    /*
    |--------------------------------------------------------------------------
    | CUSTOM ROUTE UNTUK HAPUS FILE DOKUMENTASI KEJADIAN
    |--------------------------------------------------------------------------
    */
    Route::delete('/kejadian/file/{id}', [KejadianController::class, 'deleteFile'])
        ->name('kejadian.deleteFile');

    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Currently Disabled)
|--------------------------------------------------------------------------
*/
// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::get('/', fn() => redirect()->route('admin.dashboard'));
//     Route::get('/dashboard', [AdminDashboardController::class,'index'])->name('dashboard');
//     Route::resource('incidents', IncidentController::class);
// });
