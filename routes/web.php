<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KejadianController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
})->name('pcr.show');
Route::get('/mahasiswa/{param1}',[MahasiswaController::class,'show'] )->name('mahasiswa.show');
Route::get('/nama/{param1?}/{nim?}' , function ($param1='', $nim='') {
    return 'nama saya ' .$param1. '<br> nim saya ' .$nim;
})->name('mahasiswa.show');

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/', function () {
    return redirect()->route('kejadian.index');
});

Route::get('/home', [HomeController::class, 'index']);
Route::post('question/store', [QuestionController::class, 'store'])
		->name('question.store');

Route::resource('pelanggan', PelangganController::class);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('kejadian', KejadianController::class);
Route::resource('relawan', RelawanController::class);
