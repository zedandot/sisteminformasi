<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return redirect('/login');
});

// Route Login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Route Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/bap', function () {
        return view('admin.bap.index');
    });
    Route::get('/monitoring', function () {
        return view('admin.monitoring.index');
    });
});

<<<<<<< HEAD
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/bap', function () {
    return view('admin.bap.index');
});

Route::get('/admin/monitoring', function () {
    return view('admin.monitoring.index');
});

Route::get('/admin/lokasi', function () {
    return view('admin.lokasi.index');
});

=======
// Route Tim Lapangan
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});
>>>>>>> 9588da86f36a1b1bab7507c214dff37fc77493ce
