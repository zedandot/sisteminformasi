<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pekerjaan;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Pencairan;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Proyek Aktif
        $proyekAktif = Pekerjaan::whereHas('laporans', function($q) {
            $q->where('status', '!=', 'disetujui');
        })->orWhereDoesntHave('laporans')->count();

        // 2. BAP Menunggu
        $bapMenunggu = Laporan::where('status', 'dikirim')->count();

        // 3. Tim Lapangan
        $timLapangan = User::where('role', 'tim_lapangan')->count();

        // 4. Total Revenue
        $totalRevenue = Pencairan::where('status', 'cair')->sum('total_bayar');

        // 5. Aktivitas Lapangan Terbaru
        $aktivitasTerbaru = Laporan::with(['pekerjaan.lokasi', 'user'])->latest('tanggal')->take(5)->get();

        return view('admin.dashboard', compact(
            'proyekAktif',
            'bapMenunggu',
            'timLapangan',
            'totalRevenue',
            'aktivitasTerbaru'
        ));
    }
}