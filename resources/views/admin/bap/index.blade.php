@extends('layouts.admin')

@section('title', 'Sistem Pemantauan Due Date BAP')
@section('subtitle', 'Lacak batas waktu pengiriman Berita Acara Pekerjaan untuk meminimalisasi keterlambatan penagihan.')

@section('content')

<!-- BAP Due Date Status -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Kritis -->
    <div class="glass-card rounded-[2rem] p-6 bg-white border-b-4 border-red-500 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 transition-all group-hover:bg-red-100"></div>
        <div class="relative z-10">
            <h3 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">Status Kritis</h3>
            <div class="text-5xl font-black text-red-500 mb-1">{{ sprintf('%02d', $kritis) }}</div>
            <p class="text-sm font-semibold text-slate-600">Melewati 24 Jam</p>
        </div>
    </div>

    <!-- Peringatan -->
    <div class="glass-card rounded-[2rem] p-6 bg-white border-b-4 border-amber-400 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 transition-all group-hover:bg-amber-100"></div>
        <div class="relative z-10">
            <h3 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">Peringatan</h3>
            <div class="text-5xl font-black text-amber-500 mb-1">{{ sprintf('%02d', $peringatan) }}</div>
            <p class="text-sm font-semibold text-slate-600">Batas Waktu Hari Ini</p>
        </div>
    </div>

    <!-- Aman -->
    <div class="glass-card rounded-[2rem] p-6 bg-white border-b-4 border-emerald-500 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 transition-all group-hover:bg-emerald-100"></div>
        <div class="relative z-10">
            <h3 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">Aman</h3>
            <div class="text-5xl font-black text-emerald-500 mb-1">{{ sprintf('%02d', $aman) }}</div>
            <p class="text-sm font-semibold text-slate-600">BAP Selesai & Terkirim</p>
        </div>
    </div>

</div>

<!-- List of BAPs -->
<div class="mt-10">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1.5 h-6 bg-brand-500 rounded-full"></div>
        <h3 class="text-xl font-bold tracking-tight text-slate-800">Daftar Antrean Berita Acara (BAP)</h3>
        
        <!-- Filter/Sort -->
        <div class="ml-auto flex gap-2">
            <span class="px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-xs font-bold shrink-0 shadow-sm border border-blue-100">{{ $laporans->count() }} Laporan Disetujui</span>
        </div>
    </div>

    <div class="space-y-4">
        
        @forelse($laporans as $laporan)
        <div class="glass-card bg-white border border-blue-100 rounded-[2rem] p-6 flex flex-col md:flex-row items-center gap-6 relative shadow-[0_8px_30px_rgb(59,130,246,0.05)] hover:shadow-[0_8px_30px_rgb(59,130,246,0.15)] transition-all duration-300">
            <!-- Icon -->
            <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 border border-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            
            <div class="flex-1">
                <h4 class="text-lg font-bold text-slate-800 mb-1">{{ $laporan->pekerjaan->nama_pekerjaan }}</h4>
                <p class="text-sm font-medium text-slate-500 mb-4">Klien: {{ $laporan->pekerjaan->client->nama ?? '-' }} <span class="mx-2 text-slate-300">|</span> Lokasi: {{ $laporan->pekerjaan->lokasi->nama_lokasi ?? '-' }}</p>
                
                <!-- Thumbnails Transparansi -->
                <div class="flex items-center gap-3 mt-2">
                    @php 
                        $fotoBefore = $laporan->fotos->where('tipe', 'before')->first();
                        $fotoAfter = $laporan->fotos->where('tipe', 'after')->first();
                    @endphp
                    
                    @if($fotoBefore)
                    <div class="relative group/img cursor-pointer" onclick="window.open('{{ asset('storage/' . $fotoBefore->file_path) }}', '_blank')">
                        <img src="{{ asset('storage/' . $fotoBefore->file_path) }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-amber-500 rounded-full text-white flex items-center justify-center text-[10px] font-bold border-2 border-white shadow-sm" title="Before">B</div>
                    </div>
                    @endif
                    
                    @if($fotoAfter)
                    <div class="relative group/img cursor-pointer" onclick="window.open('{{ asset('storage/' . $fotoAfter->file_path) }}', '_blank')">
                        <img src="{{ asset('storage/' . $fotoAfter->file_path) }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-emerald-500 rounded-full text-white flex items-center justify-center text-[10px] font-bold border-2 border-white shadow-sm" title="After">A</div>
                    </div>
                    @endif

                    <div class="ml-2 inline-flex items-center gap-2 text-xs font-bold px-3 py-1.5 bg-slate-50 text-slate-600 rounded-lg border border-slate-200">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tervalidasi GPS
                    </div>
                </div>
            </div>

            <div class="text-right shrink-0">
                <div class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-1">Disetujui Tanggal</div>
                <div class="text-xl font-black text-slate-800 mb-3 tracking-tighter">{{ \Carbon\Carbon::parse($laporan->updated_at)->format('d M Y') }}</div>
                <a href="{{ route('admin.bap.cetak', $laporan->id) }}" target="_blank" class="px-6 py-2.5 bg-slate-900 hover:bg-brand-600 text-white font-bold text-sm rounded-full transition-colors shadow-lg shadow-slate-900/20 w-full md:w-auto inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak BAP
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-20 bg-white rounded-[2.5rem] border border-slate-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-lg font-bold text-slate-700 mb-2">Belum Ada BAP Siap Cetak</h3>
            <p class="text-slate-500">Validasi laporan dari Tim Lapangan di menu Monitoring Proyek untuk memunculkan antrean BAP.</p>
        </div>
        @endforelse

    </div>
</div>

@endsection
