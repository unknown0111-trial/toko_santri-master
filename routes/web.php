<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KitabController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LaporanController;

// Halaman Dashboard
Route::get('/', [DashboardController::class, 'index']);

// Route untuk Karyawan
Route::prefix('karyawan')->group(function () {
    Route::get('/', [KaryawanController::class, 'index']);
    Route::post('/list', [KaryawanController::class, 'list']);
    Route::get('/create_ajax', [KaryawanController::class, 'create_ajax']);
    Route::post('/ajax', [KaryawanController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [KaryawanController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [KaryawanController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [KaryawanController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [KaryawanController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [KaryawanController::class, 'delete_ajax']);
    Route::get('/export_excel', [KaryawanController::class, 'export_excel']);
});

// Route untuk Kitab
Route::prefix('kitab')->group(function () {
    Route::get('/', [KitabController::class, 'index']);
    Route::post('/list', [KitabController::class, 'list']);
    Route::get('/create_ajax', [KitabController::class, 'create_ajax']);
    Route::post('/ajax', [KitabController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [KitabController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [KitabController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [KitabController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [KitabController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [KitabController::class, 'delete_ajax']);
});

// Route untuk Stok
Route::prefix('stok')->group(function () {
    Route::get('/', [StokController::class, 'index']);
    Route::post('/list', [StokController::class, 'list']);
    Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
    Route::get('/rekap', [StokController::class, 'rekap']);
});

// Route untuk Penjualan (POS)
Route::prefix('penjualan')->group(function () {
    Route::get('/', [PenjualanController::class, 'index']);
    Route::post('/list', [PenjualanController::class, 'list']);
    Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
    Route::post('/ajax', [PenjualanController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
    Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
});

// Route untuk Laporan
Route::prefix('laporan')->group(function () {
    Route::get('/penjualan', [LaporanController::class, 'penjualan']);
    Route::get('/persediaan', [LaporanController::class, 'persediaan']);
    Route::get('/penjualan/export-excel', [LaporanController::class, 'exportPenjualanExcel']);
    Route::get('/penjualan/export-pdf', [LaporanController::class, 'exportPenjualanPdf']);
    Route::get('/persediaan/export-excel', [LaporanController::class, 'exportPersediaanExcel']);
    Route::get('/persediaan/export-pdf', [LaporanController::class, 'exportPersediaanPdf']);
});