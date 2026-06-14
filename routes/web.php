<?php

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

    Route::view('/admin/dashboard', 'admin.dashboard')
        ->middleware('admin')
        ->name('admin.dashboard');

    Route::view('/anggota/dashboard', 'anggota.dashboard')
        ->middleware('anggota')
        ->name('anggota.dashboard');
});
