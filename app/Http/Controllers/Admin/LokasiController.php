<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;

class LokasiController extends Controller
{
    public function index()
    {
        // Get the latest photos with valid GPS coordinates
        $laporans = Laporan::with(['pekerjaan.lokasi', 'user', 'fotos'])->latest('updated_at')->take(20)->get();
        
        $markers = [];
        foreach ($laporans as $laporan) {
            foreach ($laporan->fotos as $foto) {
                if ($foto->gps) {
                    $coords = explode(',', $foto->gps);
                    if (count($coords) == 2) {
                        $markers[] = [
                            'lat' => trim($coords[0]),
                            'lng' => trim($coords[1]),
                            'popup' => '<b>' . ($laporan->pekerjaan->nama_pekerjaan ?? 'Pekerjaan') . '</b><br>' .
                                       'Tim: ' . ($laporan->user->name ?? 'Unknown') . '<br>' .
                                       'Status: ' . $laporan->status . '<br>' .
                                       'Tipe Foto: ' . ucfirst($foto->tipe) . '<br>' .
                                       'Waktu: ' . $foto->timestamp
                        ];
                    }
                }
            }
        }

        return view('admin.lokasi.index', compact('markers'));
    }
}
