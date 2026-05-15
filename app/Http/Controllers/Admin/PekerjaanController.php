<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pekerjaan;
use App\Models\Client;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function index()
    {
        $pekerjaans = Pekerjaan::with(['client', 'lokasi', 'user'])->latest()->get();
        $clients = Client::all();
        $lokasis = Lokasi::all();
        $timLapangans = \App\Models\User::where('role', 'tim_lapangan')->get();
        return view('admin.pekerjaan.index', compact('pekerjaans', 'clients', 'lokasis', 'timLapangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'client_nama' => 'required|string|max:255',
            'lokasi_nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status' => 'nullable|in:Aktif,Selesai,Pending',
            'user_id' => 'nullable|exists:users,id',
            'no_po' => 'nullable|string|max:255',
        ]);

        $client = Client::firstOrCreate([
            'nama' => $request->client_nama,
        ], [
            'alamat' => '-'
        ]);

        $lokasi = Lokasi::firstOrCreate([
            'nama_lokasi' => $request->lokasi_nama,
        ], [
            'client_id' => $client->id,
            'alamat' => '-'
        ]);

        $pekerjaanData = $request->except(['lokasi_nama', 'client_nama']);
        $pekerjaanData['client_id'] = $client->id;
        $pekerjaanData['lokasi_id'] = $lokasi->id;
        $pekerjaanData['status'] = $request->status ?? 'Aktif';

        $pekerjaan = Pekerjaan::create($pekerjaanData);

        if ($pekerjaan->user_id) {
            \App\Models\Notifikasi::create([
                'user_id' => $pekerjaan->user_id,
                'pesan' => "Anda telah di-assign ke proyek baru: {$pekerjaan->nama_pekerjaan}.",
                'status_baca' => false
            ]);
        }

        return back()->with('success', 'Proyek / Pekerjaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'client_nama' => 'required|string|max:255',
            'lokasi_nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status' => 'required|in:Aktif,Selesai,Pending',
            'user_id' => 'nullable|exists:users,id',
            'no_po' => 'nullable|string|max:255',
        ]);

        $client = Client::firstOrCreate([
            'nama' => $request->client_nama,
        ], [
            'alamat' => '-'
        ]);

        $lokasi = Lokasi::firstOrCreate([
            'nama_lokasi' => $request->lokasi_nama,
        ], [
            'client_id' => $client->id,
            'alamat' => '-'
        ]);

        $pekerjaanData = $request->except(['lokasi_nama', 'client_nama']);
        $pekerjaanData['client_id'] = $client->id;
        $pekerjaanData['lokasi_id'] = $lokasi->id;

        $pekerjaan = Pekerjaan::findOrFail($id);
        
        $oldUserId = $pekerjaan->user_id;
        
        $pekerjaan->update($pekerjaanData);

        if ($request->user_id && $oldUserId != $request->user_id) {
            \App\Models\Notifikasi::create([
                'user_id' => $request->user_id,
                'pesan' => "Anda telah di-assign ke proyek: {$pekerjaan->nama_pekerjaan}.",
                'status_baca' => false
            ]);
        }

        return back()->with('success', 'Proyek / Pekerjaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Pekerjaan::findOrFail($id)->delete();
        return back()->with('success', 'Proyek / Pekerjaan berhasil dihapus!');
    }
}
