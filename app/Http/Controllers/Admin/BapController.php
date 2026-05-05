<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;

class BapController extends Controller
{
    public function index()
    {
        // Get all approved laporans (BAP ready)
        $laporans = Laporan::with(['pekerjaan.lokasi', 'pekerjaan.client', 'pencairan'])
                    ->where('status', 'disetujui')
                    ->latest()
                    ->get();

        $hariIni = \Carbon\Carbon::now()->startOfDay();

        $kritis = \App\Models\Pekerjaan::where('status', '!=', 'Selesai')
                    ->whereDate('tanggal', '<', $hariIni)
                    ->count();

        $peringatan = \App\Models\Pekerjaan::where('status', '!=', 'Selesai')
                    ->whereDate('tanggal', '=', $hariIni)
                    ->count();

        $aman = Laporan::where('status', 'disetujui')->count();

        return view('admin.bap.index', compact('laporans', 'kritis', 'peringatan', 'aman'));
    }

    public function cetak($id)
    {
        $laporan = Laporan::with(['pekerjaan.lokasi', 'pekerjaan.client', 'user', 'fotos'])->findOrFail($id);
        
        // Return a print-friendly view
        return view('admin.bap.cetak', compact('laporan'));
    }
}
