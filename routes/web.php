<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KejadianController;
use App\Http\Controllers\PoskoController;
use App\Http\Controllers\DonasiBencanaController;
use App\Http\Controllers\LogistikBencanaController;
use App\Http\Controllers\DistribusiLogistikController;
use App\Http\Controllers\WargaController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::view('/', 'landing')->name('landing');

// ============================================================
// ROUTE LOGIN - LANGSUNG MASUK KE DASHBOARD (BYPASS LOGIN)
// ============================================================
Route::get('/login', function () {
    if (!auth()->check()) {
        $user = App\Models\User::first();
        if ($user) {
            auth()->login($user);
        }
    }
    return redirect()->route('dashboard');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('dashboard');
})->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================
// DASHBOARD & PROFILE - BISA DIAKSES TANPA LOGIN
// ============================================================
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
// ROUTE UNTUK MELIHAT DATA SAJA (TANPA CRUD)
// =============================================

// KEJADIAN - HANYA BISA LIHAT, TIDAK BISA TAMBAH/EDIT/HAPUS
Route::get('/kejadian', [KejadianController::class, 'index'])->name('kejadian.index');
Route::get('/kejadian/{id}', [KejadianController::class, 'show'])->name('kejadian.show');

// POSKO - HANYA BISA LIHAT, TIDAK BISA TAMBAH/EDIT/HAPUS
Route::get('/posko', [PoskoController::class, 'index'])->name('posko.index');
Route::get('/posko/{id}', [PoskoController::class, 'show'])->name('posko.show');

// DONASI - HANYA BISA LIHAT, TIDAK BISA TAMBAH/EDIT/HAPUS
Route::get('/donasi', [DonasiBencanaController::class, 'index'])->name('donasi.index');
Route::get('/donasi/{id}', [DonasiBencanaController::class, 'show'])->name('donasi.show');

// LOGISTIK - HANYA BISA LIHAT, TIDAK BISA TAMBAH/EDIT/HAPUS
Route::get('/logistik', [LogistikBencanaController::class, 'index'])->name('logistik.index');
Route::get('/logistik/{id}', [LogistikBencanaController::class, 'show'])->name('logistik.show');

// TAMBAHKAN INI: DISTRIBUSI LOGISTIK - HANYA BISA LIHAT
Route::get('/distribusi', [DistribusiLogistikController::class, 'index'])->name('distribusi.index'); // PERBAIKAN
Route::get('/distribusi/{id}', [DistribusiLogistikController::class, 'show'])->name('distribusi.show');

// TAMBAHAN: WARGA - HANYA BISA LIHAT
Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
Route::get('/warga/{id}', [WargaController::class, 'show'])->name('warga.show');

// =============================================
// ROUTE KHUSUS ADMIN SAJA (CRUD) - DIHAPUS
// =============================================
// Route::middleware([AdminMiddleware::class])->group(function () {
//     SEMUA ROUTE CRUD SUDAH DIHAPUS
//     TIDAK ADA LAGI ROUTE CREATE, STORE, EDIT, UPDATE, DESTROY
// });

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE (404)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect()->route('dashboard');
});