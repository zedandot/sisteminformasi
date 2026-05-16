<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use Carbon\Carbon;

class PelacakanBapController extends Controller
{
    public function index()
    {
        // Get all approved laporans (BAP ready)
        $laporans = Laporan::with(['pekerjaan.lokasi', 'pekerjaan.client', 'pencairan'])
                    ->where('status', 'disetujui')
                    ->latest()
                    ->get();

        return view('admin.pelacakan-bap.index', compact('laporans'));
    }

    public function kirim(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        
        $laporan->update([
            'status_pengiriman_bap' => 'sudah_dikirim',
            'tanggal_kirim_bap' => Carbon::now()->toDateString()
        ]);

        return redirect()->back()->with('success', 'Status BAP berhasil diubah menjadi Sudah Dikirim.');
    }
}
