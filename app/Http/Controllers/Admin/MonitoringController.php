<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index()
    {
        // Fetch laporans that need validation or are already validated
        $laporans = Laporan::with(['pekerjaan.lokasi', 'user', 'fotos'])->latest('updated_at')->get();
        return view('admin.monitoring.index', compact('laporans'));
    }

    public function validasi(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $request->validate([
            'status' => 'required|in:disetujui,ditolak' 
        ]);

        $laporan->update(['status' => $request->status]);

        if ($request->status == 'disetujui') {
            $laporan->pekerjaan->update(['status' => 'Selesai']);
            $pesan = "Laporan Anda untuk proyek {$laporan->pekerjaan->nama_pekerjaan} telah DISETUJUI dan BAP telah diterbitkan.";
        } else {
            $pesan = "Laporan Anda untuk proyek {$laporan->pekerjaan->nama_pekerjaan} DITOLAK. Silakan periksa kembali dan kirim ulang.";
        }

        // Create Notification for Tim Lapangan
        \App\Models\Notifikasi::create([
            'user_id' => $laporan->user_id,
            'pesan' => $pesan,
            'status_baca' => false
        ]);

        return redirect()->back()->with('success', 'Status Laporan berhasil diperbarui.');
    }
}
