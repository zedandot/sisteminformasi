<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak BAP - {{ $laporan->pekerjaan->nama_pekerjaan }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @page { size: A4; margin: 20mm; }
        @media print {
            body { background: white; }
            .no-print { display: none; }
            .print-break { page-break-before: always; }
        }
        body { background: #f1f5f9; }
        .a4-container {
            background: white;
            width: 210mm;
            min-height: 297mm;
            margin: 2rem auto;
            padding: 20mm;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }
    </style>
</head>
<body class="text-slate-800">

    <!-- Print Action Button (Hidden on Print) -->
    <div class="no-print text-center py-6 bg-slate-900 sticky top-0 z-50 shadow-xl">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-full font-bold shadow-lg flex items-center gap-2 mx-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Dokumen BAP ke PDF
        </button>
    </div>

    <!-- A4 Document Page 1 -->
    <div class="a4-container relative">
        
        <!-- Header / KOP Surat -->
        <div class="border-b-4 border-slate-900 pb-6 mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Berita Acara Pekerjaan</h1>
                <p class="text-sm font-bold text-slate-500 tracking-widest mt-1">CV. ASA KARYA ALAM</p>
            </div>
            <div class="text-right text-xs text-slate-500">
                <p>No. Ref: BAP-{{ str_pad($laporan->id, 5, '0', STR_PAD_LEFT) }}/{{ date('m/Y') }}</p>
                <p>Tanggal Cetak: {{ now()->format('d F Y') }}</p>
            </div>
        </div>

        <!-- Content -->
        <div class="space-y-6 text-sm leading-relaxed">
            <p>Pada hari ini <strong>{{ \Carbon\Carbon::parse($laporan->updated_at)->isoFormat('dddd, D MMMM Y') }}</strong>, telah diselesaikan dan diperiksa pekerjaan dengan rincian sebagai berikut:</p>

            <table class="w-full border border-slate-300">
                <tbody>
                    <tr>
                        <td class="w-1/3 py-2 px-4 border-b border-slate-300 font-bold bg-slate-50">Nama Klien</td>
                        <td class="py-2 px-4 border-b border-slate-300">{{ $laporan->pekerjaan->client->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b border-slate-300 font-bold bg-slate-50">Lokasi / Proyek</td>
                        <td class="py-2 px-4 border-b border-slate-300">{{ $laporan->pekerjaan->lokasi->nama_lokasi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b border-slate-300 font-bold bg-slate-50">Alamat Lokasi</td>
                        <td class="py-2 px-4 border-b border-slate-300">{{ $laporan->pekerjaan->lokasi->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b border-slate-300 font-bold bg-slate-50">Jenis Pekerjaan</td>
                        <td class="py-2 px-4 border-b border-slate-300">{{ $laporan->pekerjaan->nama_pekerjaan }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b border-slate-300 font-bold bg-slate-50">Tim Pelaksana</td>
                        <td class="py-2 px-4 border-b border-slate-300">{{ $laporan->user->name }}</td>
                    </tr>
                </tbody>
            </table>

            <p>Berdasarkan hasil pemantauan dan validasi foto GPS yang terlampir pada dokumen ini, pekerjaan di atas dinyatakan <strong>SELESAI</strong> dan sesuai dengan standar operasi yang berlaku.</p>

            <p>Demikian Berita Acara Pekerjaan ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagai syarat pencairan/penagihan (Invoice) kepada Klien yang bersangkutan.</p>
        </div>

        <!-- Signatures -->
        <div class="mt-20 flex justify-between text-center text-sm">
            <div>
                <p class="mb-20">Dibuat Oleh,<br><strong>Tim Lapangan</strong></p>
                <p class="font-bold underline">{{ $laporan->user->name }}</p>
            </div>
            <div>
                <p class="mb-20">Mengetahui,<br><strong>Pihak Klien</strong></p>
                <p class="font-bold underline">(.......................................)</p>
            </div>
            <div>
                <p class="mb-20">Disetujui Oleh,<br><strong>Admin Pusat</strong></p>
                <p class="font-bold underline">Admin Utama</p>
            </div>
        </div>

    </div>

    <!-- A4 Document Page 2 (Lampiran Foto) -->
    <div class="a4-container print-break">
        <h2 class="text-xl font-bold mb-6 border-b-2 border-slate-200 pb-2">Lampiran Dokumentasi (Validasi Sistem)</h2>
        
        <div class="grid grid-cols-1 gap-8">
            @php
                $fotoBefore = $laporan->fotos->where('tipe', 'before')->first();
                $fotoAfter = $laporan->fotos->where('tipe', 'after')->first();
            @endphp
            
            <!-- Before -->
            <div class="border border-slate-300 rounded-xl p-4">
                <h3 class="font-bold text-red-600 mb-2">Kondisi Awal (Before)</h3>
                @if($fotoBefore)
                    <img src="{{ Storage::url($fotoBefore->file_path) }}" alt="Before" class="w-full h-[400px] object-cover rounded-lg border border-slate-200 mb-3">
                    <div class="text-xs font-mono bg-slate-100 p-2 rounded">
                        <div>Waktu: {{ $fotoBefore->timestamp }}</div>
                        <div>GPS: {{ $fotoBefore->gps }}</div>
                    </div>
                @else
                    <div class="h-32 flex items-center justify-center bg-slate-100 border border-slate-200 text-slate-400">Tidak ada foto before</div>
                @endif
            </div>

            <!-- After -->
            <div class="border border-slate-300 rounded-xl p-4">
                <h3 class="font-bold text-green-600 mb-2">Kondisi Selesai (After)</h3>
                @if($fotoAfter)
                    <img src="{{ Storage::url($fotoAfter->file_path) }}" alt="After" class="w-full h-[400px] object-cover rounded-lg border border-slate-200 mb-3">
                    <div class="text-xs font-mono bg-slate-100 p-2 rounded">
                        <div>Waktu: {{ $fotoAfter->timestamp }}</div>
                        <div>GPS: {{ $fotoAfter->gps }}</div>
                    </div>
                @else
                    <div class="h-32 flex items-center justify-center bg-slate-100 border border-slate-200 text-slate-400">Tidak ada foto after</div>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
