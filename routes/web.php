<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KelasLombaController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;


Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== Event =====
    // 1) Halaman buat event baru (SEMARFIN Event)
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    
    // Penambahan Route Hapus
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // 2) Halaman daftar untuk dikelola (menu baru "Kelola Event")
    Route::get('/manage-events', [EventController::class, 'manageIndex'])->name('events.manage_index');

    // 3) Kelola 1 event
    Route::get('/events/{event}/manage', [EventController::class, 'manage'])->name('events.manage');

    // Export
    Route::get('/events/{event}/export', [EventController::class, 'export'])->name('events.export');

    // (Opsional) Sisa route lama untuk auto-saldo—boleh dihapus kalau sudah tidak dipakai
    // Route::get('/events/last-balance', [EventController::class, 'lastBalance'])->name('events.last_balance');

    // ===== Kelas Lomba =====
    Route::post('/kelas-lomba', [KelasLombaController::class, 'store'])->name('kelas.store');
    Route::put('/kelas-lomba/{kelasLomba}', [KelasLombaController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas-lomba/{kelasLomba}', [KelasLombaController::class, 'destroy'])->name('kelas.destroy');
    Route::get('/kelas-lomba/{kelasLomba}/edit', [KelasLombaController::class, 'edit'])->name('kelas.edit');

    // ===== Pengeluaran =====
    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::put('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    // ===== Profil =====
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('/reports/{event}/export', [ReportController::class, 'export'])
        ->name('reports.export');
});

require __DIR__ . '/auth.php';