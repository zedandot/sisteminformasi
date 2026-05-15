@extends('layouts.admin')

@section('title', 'Validasi Foto Projek')
@section('subtitle', 'Tinjau bukti foto lapangan Before-After yang dikirimkan oleh tim.')

@section('content')

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl mb-8 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8">
        @forelse($laporans as $laporan)
            <div class="bg-white rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 border border-slate-100 shadow-sm relative overflow-hidden">
                <!-- Status Ribbon -->
                <div class="mb-4 md:absolute md:top-8 md:right-8 md:mb-0">
                    @if($laporan->status == 'disetujui')
                        <span
                            class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold uppercase tracking-wider">BAP
                            Disetujui</span>
                    @elseif($laporan->status == 'ditolak')
                        <span
                            class="inline-block px-4 py-2 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase tracking-wider">Ditolak</span>
                    @else
                        <span
                            class="inline-block px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-xs font-bold uppercase tracking-wider"><span
                                class="inline-block w-2 h-2 rounded-full bg-amber-500 animate-pulse mr-2"></span>Menunggu
                            Validasi</span>
                    @endif
                </div>

                <div class="flex flex-col md:flex-row items-start gap-4 md:gap-8 mb-8">
                    <div
                        class="w-16 h-16 rounded-2xl bg-brand-50 border border-brand-100 flex items-center justify-center shrink-0">
                        <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="text-xl font-bold text-slate-800">{{ $laporan->pekerjaan->nama_pekerjaan }}</h4>
                            <span
                                class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-semibold">{{ $laporan->pekerjaan->client->nama ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-slate-400 mb-1">Tim Lapangan</p>
                                <p class="font-semibold text-slate-700">{{ $laporan->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 mb-1">Tanggal & Waktu</p>
                                <p class="font-semibold text-slate-700">
                                    {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-slate-400 mb-1">Lokasi Proyek</p>
                                <p class="font-semibold text-slate-700">{{ $laporan->pekerjaan->lokasi->nama_lokasi ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto Bukti -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Foto Before -->
                    @php $fotoBefore = $laporan->fotos->where('tipe', 'before')->first(); @endphp
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold uppercase tracking-wider">Kondisi
                                Awal (Before)</span>
                            @if($fotoBefore)
                                <span class="text-xs text-slate-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    GPS Valid
                                </span>
                            @endif
                        </div>
                        @if($fotoBefore)
                            <div class="aspect-video rounded-xl overflow-hidden bg-slate-200 mb-3 group relative cursor-pointer"
                                onclick="window.open('{{ asset('storage/' . $fotoBefore->file_path) }}', '_blank')">
                                <img src="{{ asset('storage/' . $fotoBefore->file_path) }}" alt="Before"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div
                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-100 text-xs text-slate-500 font-mono">
                                {{ $fotoBefore->gps }}
                            </div>
                        @else
                            <div
                                class="aspect-video rounded-xl bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center flex-col text-slate-400">
                                <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p>Foto Before Belum Ada</p>
                            </div>
                        @endif
                    </div>

                    <!-- Foto After -->
                    @php $fotoAfter = $laporan->fotos->where('tipe', 'after')->first(); @endphp
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="px-3 py-1 bg-brand-100 text-brand-700 rounded-lg text-xs font-bold uppercase tracking-wider">Hasil
                                Pekerjaan (After)</span>
                            @if($fotoAfter)
                                <span class="text-xs text-slate-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    GPS Valid
                                </span>
                            @endif
                        </div>
                        @if($fotoAfter)
                            <div class="aspect-video rounded-xl overflow-hidden bg-slate-200 mb-3 group relative cursor-pointer"
                                onclick="window.open('{{ asset('storage/' . $fotoAfter->file_path) }}', '_blank')">
                                <img src="{{ asset('storage/' . $fotoAfter->file_path) }}" alt="After"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div
                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-100 text-xs text-slate-500 font-mono">
                                {{ $fotoAfter->gps }}
                            </div>
                        @else
                            <div
                                class="aspect-video rounded-xl bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center flex-col text-slate-400">
                                <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p>Foto After Belum Ada</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Form -->
                @if(in_array($laporan->status, ['dikirim', 'draft']))
                    <form action="{{ route('admin.monitoring.validasi', $laporan->id) }}" method="POST"
                        class="flex flex-col md:flex-row items-stretch md:items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        @csrf
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-600">Pastikan titik GPS dan kemajuan pekerjaan pada foto di
                                atas sesuai sebelum memberikan validasi BAP.</p>
                        </div>
                        <button type="submit" name="status" value="ditolak"
                            class="px-6 py-3 w-full md:w-auto bg-white border border-red-200 text-red-600 hover:bg-red-50 font-bold rounded-xl transition-colors">Tolak
                            Laporan</button>
                        <button type="submit" name="status" value="disetujui"
                            class="px-6 py-3 w-full md:w-auto bg-blue-600 text-white hover:bg-blue-700 font-bold rounded-xl shadow-lg shadow-blue-200 transition-all">Setujui
                            & Buat BAP</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-[2.5rem] border border-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-slate-300 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-bold text-slate-700 mb-2">Tidak Ada Laporan</h3>
                <p class="text-slate-500">Belum ada tim lapangan yang mengirimkan progress pekerjaan.</p>
            </div>
        @endforelse
    </div>

@endsection