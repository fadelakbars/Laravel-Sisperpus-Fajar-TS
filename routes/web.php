<?php

use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->adalahAdmin()
            ? to_route('admin.dashboard')
            : to_route('anggota.dashboard');
    }

    return view('welcome');
})->name('beranda');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::prefix('admin')
        ->as('admin.')
        ->middleware('admin')
        ->group(function () {
            Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
            Route::resource('buku', BukuController::class)->except('show');
            Route::resource('anggota', AnggotaController::class)
                ->parameters(['anggota' => 'anggota'])
                ->except('show');
            Route::resource('peminjaman', PeminjamanController::class)
                ->only(['index', 'create', 'store']);
            Route::patch('peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
                ->name('peminjaman.kembalikan');
        });

    Route::get('/anggota/dashboard', [AnggotaDashboardController::class, 'index'])
        ->middleware('anggota')
        ->name('anggota.dashboard');
});
