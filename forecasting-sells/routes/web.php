<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\EvaluasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/penjualan/import', [PenjualanController::class, 'import'])->name('penjualan.import');
    Route::delete('/penjualan/clear-all', [PenjualanController::class, 'clearAll'])->name('penjualan.clearAll');

    Route::resource('penjualan', PenjualanController::class);

    Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi.index');
    Route::post('/prediksi/proses', [PrediksiController::class, 'proses'])->name('prediksi.proses');

    Route::get('/evaluasi', [EvaluasiController::class, 'index'])->name('evaluasi.index');
});

require __DIR__.'/auth.php';