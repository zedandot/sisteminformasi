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
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/pekerjaan', \App\Http\Controllers\Admin\PekerjaanController::class)->names('admin.pekerjaan');
    Route::get('/bap', [\App\Http\Controllers\Admin\BapController::class, 'index'])->name('admin.bap');
    Route::get('/bap/{id}/cetak', [\App\Http\Controllers\Admin\BapController::class, 'cetak'])->name('admin.bap.cetak');
    Route::get('/pelacakan-bap', [\App\Http\Controllers\Admin\PelacakanBapController::class, 'index'])->name('admin.pelacakan-bap');
    Route::post('/pelacakan-bap/{id}/kirim', [\App\Http\Controllers\Admin\PelacakanBapController::class, 'kirim'])->name('admin.pelacakan-bap.kirim');
    Route::get('/monitoring', [\App\Http\Controllers\Admin\MonitoringController::class, 'index'])->name('admin.monitoring');
    Route::post('/monitoring/validasi/{id}', [\App\Http\Controllers\Admin\MonitoringController::class, 'validasi'])->name('admin.monitoring.validasi');
    Route::get('/lokasi', [\App\Http\Controllers\Admin\LokasiController::class, 'index'])->name('admin.lokasi');
    
    Route::get('/notifikasi/{id}/read', function ($id) {
        $notif = \App\Models\Notifikasi::findOrFail($id);
        if ($notif->user_id == Auth::guard('admin')->id()) {
            $notif->update(['status_baca' => true]);
        }
        return redirect()->route('admin.monitoring');
    })->name('admin.notifikasi.read');
});

// Route Tim Lapangan
Route::middleware(['auth:web,admin'])->group(function () {
    Route::get('/home', function () {
        $semuaPekerjaan = \App\Models\Pekerjaan::with('lokasi')
            ->where(function($query) {
                $query->where('user_id', Auth::id())
                      ->orWhereNull('user_id');
            })->get();

        $pekerjaans = $semuaPekerjaan->where('status', '!=', 'Selesai');
        $totalTugas = $semuaPekerjaan->count();
        $tugasSelesai = $semuaPekerjaan->where('status', 'Selesai')->count();

        return view('home', compact('pekerjaans', 'totalTugas', 'tugasSelesai'));
    })->name('home');
});

// Route untuk detail pekerjaan (dipakai di email, reminder, Google Calendar)
Route::get('/pekerjaan/{pekerjaan}', function (\App\Models\Pekerjaan $pekerjaan) {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.pekerjaan.show', $pekerjaan->id);
    }
    return redirect()->route('home');
})->name('pekerjaan.show')->middleware('auth:web,admin');

Route::middleware(['auth:web'])->group(function () {

    Route::get('/input-progres', [\App\Http\Controllers\TimLapanganController::class, 'index'])->name('tim.input');
    Route::post('/input-progres', [\App\Http\Controllers\TimLapanganController::class, 'store'])->name('tim.input.store');
    
    // Google Calendar Routes
    Route::get('/google-calendar/authorize', [\App\Http\Controllers\GoogleCalendarAuthController::class, 'show'])->name('google-calendar.show');
    Route::get('/google-calendar/start', [\App\Http\Controllers\GoogleCalendarAuthController::class, 'authorize'])->name('google-calendar.authorize');
    Route::get('/auth/google/callback', [\App\Http\Controllers\GoogleCalendarAuthController::class, 'callback'])->name('google-calendar.callback');
    Route::post('/google-calendar/revoke', [\App\Http\Controllers\GoogleCalendarAuthController::class, 'revoke'])->name('google-calendar.revoke');
});
