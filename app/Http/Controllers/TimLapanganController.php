<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use App\Models\Laporan;
use App\Models\Foto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TimLapanganController extends Controller
{
    public function index()
    {
        // Get active projects assigned to this user
        $pekerjaans = Pekerjaan::with('lokasi')
                        ->where(function($query) {
                            $query->where('user_id', Auth::id())
                                  ->orWhereNull('user_id');
                        })
                        ->where('status', '!=', 'Selesai')
                        ->get();
                        
        return view('tim.input', compact('pekerjaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'foto_before' => 'nullable|image|max:5120', // max 5MB
            'foto_after' => 'nullable|image|max:5120', // max 5MB
            'gps_latitude' => 'required',
            'gps_longitude' => 'required',
        ]);

        if (!$request->hasFile('foto_before') && !$request->hasFile('foto_after')) {
            return back()->withErrors(['foto' => 'Minimal salah satu foto (Before atau After) harus diunggah.']);
        }

        // Find or create laporan for today for this project
        $laporan = Laporan::firstOrCreate(
            [
                'pekerjaan_id' => $request->pekerjaan_id,
                'user_id' => Auth::id(),
                'tanggal' => now()->toDateString(),
            ],
            [
                'status' => 'draft'
            ]
        );

        $gpsStr = $request->gps_latitude . ',' . $request->gps_longitude;

        if ($request->hasFile('foto_before')) {
            $path = $request->file('foto_before')->store('laporan_fotos', 'public');
            Foto::create([
                'laporan_id' => $laporan->id,
                'tipe' => 'before',
                'file_path' => $path,
                'gps' => $gpsStr,
                'timestamp' => now()
            ]);
        }

        if ($request->hasFile('foto_after')) {
            $path = $request->file('foto_after')->store('laporan_fotos', 'public');
            Foto::create([
                'laporan_id' => $laporan->id,
                'tipe' => 'after',
                'file_path' => $path,
                'gps' => $gpsStr,
                'timestamp' => now()
            ]);
            
            $laporan->update(['status' => 'dikirim']);
            
            // Create Notification for Admin
            \App\Models\Notifikasi::create([
                'user_id' => \App\Models\User::where('role', 'admin')->first()->id,
                'pesan' => 'Laporan BAP baru dari Tim Lapangan untuk diverifikasi.',
                'status_baca' => false
            ]);
        }

        return redirect()->back()->with('success', 'Laporan foto progres berhasil dikirim dengan lokasi GPS terverifikasi!');
    }
}
