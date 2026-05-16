@extends('layouts.admin')

@section('title', 'Pelacakan BAP')
@section('subtitle', 'Lacak status pengiriman Berita Acara Pekerjaan ke Head Office.')

@section('content')

<div class="mt-4">
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-6 bg-brand-500 rounded-full"></div>
            <h3 class="text-lg sm:text-xl font-bold tracking-tight text-slate-800">Daftar Status Pengiriman BAP</h3>
        </div>
        
        <div class="sm:ml-auto flex gap-2">
            <span class="px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-xs font-bold shrink-0 shadow-sm border border-blue-100">{{ $laporans->count() }} Total BAP</span>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-emerald-700 bg-emerald-100 rounded-xl font-medium border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4">
        
        @forelse($laporans as $laporan)
        @php
            $isTerkirim = $laporan->status_pengiriman_bap === 'sudah_dikirim';
            $tanggalKirim = $laporan->tanggal_kirim_bap ? \Carbon\Carbon::parse($laporan->tanggal_kirim_bap) : null;
            
            $harusCair = false;
            if ($isTerkirim && $tanggalKirim) {
                // Check if one month has passed
                $satuBulanKemudian = $tanggalKirim->copy()->addMonth();
                if (\Carbon\Carbon::now()->startOfDay()->gte($satuBulanKemudian->startOfDay())) {
                    $harusCair = true;
                }
            }
        @endphp

        <div class="glass-card bg-white border {{ $harusCair ? 'border-red-200' : 'border-slate-100' }} rounded-[2rem] p-6 flex flex-col md:flex-row items-start md:items-center gap-6 relative shadow-sm hover:shadow-md transition-all duration-300">
            
            <div class="w-14 h-14 rounded-full {{ $isTerkirim ? 'bg-emerald-50 text-emerald-500 border-emerald-100' : 'bg-amber-50 text-amber-500 border-amber-100' }} flex items-center justify-center shrink-0 border">
                @if($isTerkirim)
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                @else
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @endif
            </div>
            
            <div class="flex-1">
                <h4 class="text-lg font-bold text-slate-800 mb-1">{{ $laporan->pekerjaan->nama_pekerjaan }}</h4>
                <p class="text-sm font-medium text-slate-500 mb-2">Klien: {{ $laporan->pekerjaan->client->nama ?? '-' }} <span class="mx-2 text-slate-300">|</span> Lokasi: {{ $laporan->pekerjaan->lokasi->nama_lokasi ?? '-' }}</p>
                
                @if($isTerkirim)
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-100 text-xs font-bold text-emerald-600 mb-2">
                        BAP Sudah Dikirim pada {{ $tanggalKirim->translatedFormat('d F Y') }}
                    </div>
                    @if($harusCair)
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-50 border border-red-200 text-xs font-bold text-red-600 animate-pulse mt-2 md:mt-0 md:ml-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            BAP ini harus dicairin
                        </div>
                    @endif
                @else
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-100 text-xs font-bold text-amber-600">
                        BAP Belum Dikirim
                    </div>
                @endif
            </div>

            <div class="w-full md:w-auto shrink-0 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-0 border-slate-100">
                @if(!$isTerkirim)
                <form action="{{ route('admin.pelacakan-bap.kirim', $laporan->id) }}" method="POST" onsubmit="return confirm('Tandai BAP ini sebagai Sudah Dikirim?');">
                    @csrf
                    <button type="submit" class="w-full px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-full transition-colors shadow-lg shadow-blue-600/20 inline-flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        BAP Sudah Dikirim
                    </button>
                </form>
                @else
                <button type="button" disabled class="w-full px-6 py-2.5 bg-slate-100 text-slate-400 font-bold text-sm rounded-full cursor-not-allowed inline-flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Terkirim
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-20 bg-white rounded-[2.5rem] border border-slate-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <h3 class="text-lg font-bold text-slate-700 mb-2">Belum Ada BAP untuk Dilacak</h3>
            <p class="text-slate-500">BAP yang sudah disetujui akan otomatis masuk ke daftar ini.</p>
        </div>
        @endforelse

    </div>
</div>

@endsection
