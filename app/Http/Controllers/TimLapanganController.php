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
    public function index(Request $request)
    {
        // Get active projects assigned to this user
        $pekerjaans = Pekerjaan::with('lokasi')
                        ->where(function($query) {
                            $query->where('user_id', Auth::id())
                                  ->orWhereNull('user_id');
                        })
                        ->where('status', '!=', 'Selesai')
                        ->get();
        
        $laporan = null;
        if ($request->pekerjaan_id) {
            $laporan = Laporan::with('fotos')->where('pekerjaan_id', $request->pekerjaan_id)
                        ->where('user_id', Auth::id())
                        ->whereIn('status', ['draft', 'dikirim'])
                        ->latest()
                        ->first();
        }
                        
        return view('tim.input', compact('pekerjaans', 'laporan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'foto_before.*' => 'nullable|image|max:5120', // max 5MB
            'foto_after.*' => 'nullable|image|max:5120', // max 5MB
            'gps_latitude' => 'required',
            'gps_longitude' => 'required',
        ]);

        if (!$request->hasFile('foto_before') && !$request->hasFile('foto_after')) {
            return back()->withErrors(['foto' => 'Minimal satu foto harus diunggah.']);
        }

        // Find existing draft laporan for this project, or create a new one
        $laporan = Laporan::where('pekerjaan_id', $request->pekerjaan_id)
                    ->where('user_id', Auth::id())
                    ->where('status', 'draft')
                    ->first();

        if (!$laporan) {
            $laporan = Laporan::create([
                'pekerjaan_id' => $request->pekerjaan_id,
                'user_id' => Auth::id(),
                'tanggal' => now()->toDateString(),
                'status' => 'draft'
            ]);
        }

        $gpsStr = $request->gps_latitude . ',' . $request->gps_longitude;

        if ($request->hasFile('foto_before')) {
            foreach ($request->file('foto_before') as $file) {
                $path = $file->store('laporan_fotos', 'public');
                Foto::create([
                    'laporan_id' => $laporan->id,
                    'tipe' => 'before',
                    'file_path' => $path,
                    'gps' => $gpsStr,
                    'timestamp' => now()
                ]);
            }
        }

        if ($request->hasFile('foto_after')) {
            foreach ($request->file('foto_after') as $file) {
                $path = $file->store('laporan_fotos', 'public');
                Foto::create([
                    'laporan_id' => $laporan->id,
                    'tipe' => 'after',
                    'file_path' => $path,
                    'gps' => $gpsStr,
                    'timestamp' => now()
                ]);
            }
            
            $laporan->update(['status' => 'dikirim']);
            
            // Fetch pekerjaan for the name
            $pekerjaan = Pekerjaan::find($request->pekerjaan_id);
            
            // Create Notification for Admin
            \App\Models\Notifikasi::create([
                'user_id' => \App\Models\User::where('role', 'admin')->first()->id,
                'pesan' => 'Progres baru: Tim Lapangan telah mengunggah foto untuk proyek "' . $pekerjaan->nama_pekerjaan . '". Silakan validasi.',
                'status_baca' => false
            ]);
        }

        return redirect()->back()->with('success', 'Laporan foto progres berhasil dikirim dengan lokasi GPS terverifikasi!');
    }
}
