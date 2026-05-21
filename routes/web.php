<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienMasukController;
use App\Http\Controllers\PasienKeluarController;
use App\Http\Controllers\SensusController;
use App\Http\Controllers\RekapController;

// LOGIN & LOGOUT
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// SEMUA ROLE (harus login)
Route::middleware('auth')->group(function () {

    // Dashboard & Sensus → semua role bisa akses
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('role:admin,perawat,pmik');

    Route::get('/sensus', [SensusController::class, 'index'])
        ->name('sensus')
        ->middleware('role:admin,perawat,pmik');

    Route::get('/sensus/print/{tanggal}', [SensusController::class, 'print'])
        ->name('sensus.print')
        ->middleware('role:admin,perawat,pmik');

    // Pasien Masuk & Keluar → admin & perawat
    Route::resource('/pasien-masuk', PasienMasukController::class)
        ->middleware('role:admin,perawat');
    
    Route::get('/api/cari-pasien', function(\Illuminate\Http\Request $request) {
        $keyword = $request->q;
        $pasien  = \App\Models\Pasien::where(function($q) use ($keyword) {
                        $q->where('nama_pasien', 'LIKE', "%{$keyword}%")
                        ->orWhere('no_rm', 'LIKE', "%{$keyword}%");
                    })
                    ->limit(10)
                    ->get(['id', 'nama_pasien', 'no_rm']);
        return response()->json($pasien);
    })->middleware('auth');

    Route::resource('/pasien-keluar', PasienKeluarController::class)
        ->middleware('role:admin,perawat');

    Route::get('/api/cari-pasien-aktif', [PasienKeluarController::class, 'cariPasienAktif']);

    // Rekapitulasi → admin & pmik
    Route::get('/rekap', [RekapController::class, 'index'])
        ->name('rekap')
        ->middleware('role:admin,pmik');

    Route::get('/rekap/print/{bulan}/{tahun}', [RekapController::class, 'print'])
        ->name('rekap.print')
        ->middleware('role:admin,pmik');
    
        Route::get('/api/cari-pasien', function(\Illuminate\Http\Request $request) {
        $keyword = $request->q;
        $pasien  = \App\Models\Pasien::where('nama_pasien', 'LIKE', "%{$keyword}%")
                    ->orWhere('no_rm', 'LIKE', "%{$keyword}%")
                    ->limit(10)
                    ->get(['id', 'nama_pasien', 'no_rm']);
        return response()->json($pasien);
    })->middleware('auth');
});