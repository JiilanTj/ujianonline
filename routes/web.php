<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\KelasController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\JadwalUjianController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Admin Routes
Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Student Management
    Route::resource('students', StudentController::class);

    // Kelas Management
    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
        Route::post('/', [KelasController::class, 'store'])->name('kelas.store');
        Route::delete('/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });

    // Bank Soal & Mata Pelajaran Routes
    Route::prefix('mata-pelajaran')->group(function () {
        Route::get('/', [MataPelajaranController::class, 'index'])->name('mata-pelajaran.index');
        Route::post('/', [MataPelajaranController::class, 'store'])->name('mata-pelajaran.store');
        Route::delete('/{id}', [MataPelajaranController::class, 'destroy'])->name('mata-pelajaran.destroy');
    });
    
    // Bank Soal Routes dengan struktur baru
    Route::prefix('bank-soal')->group(function () {
        Route::get('/', [BankSoalController::class, 'index'])->name('bank-soal.index');
        Route::get('/create', [BankSoalController::class, 'create'])->name('bank-soal.create');
        Route::post('/', [BankSoalController::class, 'store'])->name('bank-soal.store');
        Route::get('/{bankSoal}/edit', [BankSoalController::class, 'edit'])->name('bank-soal.edit');
        Route::put('/{bankSoal}', [BankSoalController::class, 'update'])->name('bank-soal.update');
        Route::delete('/{bankSoal}', [BankSoalController::class, 'destroy'])->name('bank-soal.destroy');
        
        // Routes untuk manajemen soal dalam bank soal
        Route::get('/{bankSoal}/soal', [BankSoalController::class, 'getSoal'])->name('bank-soal.soal.index');
        Route::post('/{bankSoal}/soal', [BankSoalController::class, 'storeSoal'])->name('bank-soal.soal.store');
        Route::put('/{bankSoal}/soal/{soal}', [BankSoalController::class, 'updateSoal'])->name('bank-soal.soal.update');
        Route::delete('/{bankSoal}/soal/{soal}', [BankSoalController::class, 'destroySoal'])->name('bank-soal.soal.destroy');
    });

    // Jadwal Ujian Routes
    Route::prefix('jadwal-ujian')->group(function () {
        Route::get('/', [JadwalUjianController::class, 'index'])->name('jadwal-ujian.index');
        Route::get('/create', [JadwalUjianController::class, 'create'])->name('jadwal-ujian.create');
        Route::post('/', [JadwalUjianController::class, 'store'])->name('jadwal-ujian.store');
        Route::get('/{jadwalUjian}/edit', [JadwalUjianController::class, 'edit'])->name('jadwal-ujian.edit');
        Route::put('/{jadwalUjian}', [JadwalUjianController::class, 'update'])->name('jadwal-ujian.update');
        Route::delete('/{jadwalUjian}', [JadwalUjianController::class, 'destroy'])->name('jadwal-ujian.destroy');
    });
});

require __DIR__.'/auth.php';
