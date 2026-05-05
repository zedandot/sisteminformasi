<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Lokasi;
use App\Models\Pekerjaan;
use App\Models\Laporan;
use App\Models\Foto;
use App\Models\Pencairan;
use App\Models\User;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $client = Client::create(['nama' => 'PT. Pembangunan Jaya', 'alamat' => 'Jl. Jend. Sudirman']);
        $lokasi1 = Lokasi::create(['client_id' => $client->id, 'nama_lokasi' => 'Mall Metropolitan, Bekasi', 'alamat' => 'Bekasi Barat']);
        $lokasi2 = Lokasi::create(['client_id' => $client->id, 'nama_lokasi' => 'Summarecon Mall Bekasi', 'alamat' => 'Bekasi Utara']);

        $pekerjaan1 = Pekerjaan::create(['client_id' => $client->id, 'lokasi_id' => $lokasi1->id, 'nama_pekerjaan' => 'Marka Parkir Area B', 'tanggal' => now()]);
        $pekerjaan2 = Pekerjaan::create(['client_id' => $client->id, 'lokasi_id' => $lokasi2->id, 'nama_pekerjaan' => 'Perbaikan Gate System', 'tanggal' => now()]);

        $tim = User::where('role', 'tim_lapangan')->first();

        $laporan1 = Laporan::create(['pekerjaan_id' => $pekerjaan1->id, 'user_id' => $tim->id, 'tanggal' => now(), 'status' => 'disetujui']);
        $laporan2 = Laporan::create(['pekerjaan_id' => $pekerjaan2->id, 'user_id' => $tim->id, 'tanggal' => now(), 'status' => 'dikirim']);

        Foto::create(['laporan_id' => $laporan1->id, 'tipe' => 'before', 'file_path' => 'dummy_before1.jpg', 'gps' => '-6.241586, 106.992416']);
        Foto::create(['laporan_id' => $laporan1->id, 'tipe' => 'after', 'file_path' => 'dummy_after1.jpg', 'gps' => '-6.241586, 106.992416']);

        Pencairan::create(['laporan_id' => $laporan1->id, 'tanggal_cair' => now(), 'status' => 'cair', 'total_bayar' => 25000000]);
        Pencairan::create(['laporan_id' => $laporan2->id, 'tanggal_cair' => null, 'status' => 'pending', 'total_bayar' => 15000000]);
    }
}
