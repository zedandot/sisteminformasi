<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tim Lapangan</title>
    <link rel="icon" href="{{ asset('cv_asa.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen text-slate-800 font-sans antialiased">
    <!-- Hero Header -->
    <div class="relative bg-slate-900 overflow-hidden shadow-2xl">
        <!-- Background Image -->
        <img src="{{ asset('images/hero_bg.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-50 mix-blend-luminosity" alt="Hero Background">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 to-slate-900/90 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
        <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-blue-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 mix-blend-screen"></div>
        <div class="absolute bottom-0 left-0 w-[40rem] h-[40rem] bg-indigo-500/20 rounded-full blur-3xl translate-y-1/3 -translate-x-1/3 mix-blend-screen"></div>

        <!-- Navigation -->
        <div class="relative z-20 border-b border-white/5">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
                <div class="flex items-center gap-2 sm:gap-4 overflow-hidden">
                    <img src="{{ asset('cv_asa.png') }}" alt="Logo CV Asa Karya Alam" class="h-10 w-10 sm:h-12 sm:w-12 scale-125 object-contain drop-shadow-md shrink-0">
                    <span class="text-white font-extrabold text-base sm:text-xl md:text-2xl tracking-tight whitespace-nowrap truncate">CV ASA KARYA ALAM
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="m-0 shrink-0 ml-2">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-white/80 hover:text-white transition-all backdrop-blur-md"
                        title="Keluar">
                        <span class="text-sm font-semibold hidden sm:inline">Keluar</span>
                        <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Hero Content -->
        <div
            class="relative z-10 max-w-6xl mx-auto px-6 pt-12 pb-20 lg:pt-16 lg:pb-24 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
            <div>
                <p class="text-blue-400 text-sm font-bold uppercase tracking-widest mb-2 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span> Tim Lapangan
                </p>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">
                    Halo, {{ Auth::user()->name ?? 'Pengguna' }}!
                </h1>
                <p class="text-slate-400 text-lg max-w-xl">
                    Berikut adalah ringkasan pekerjaan Anda hari ini. Pastikan untuk memperbarui progres secara berkala.
                </p>
            </div>

            <!-- Stats Overview -->
            <div class="flex gap-4 w-full md:w-auto">
                <div
                    class="flex-1 md:w-40 bg-white/5 backdrop-blur-xl rounded-2xl p-5 border border-white/10 shadow-2xl relative overflow-hidden group hover:bg-white/10 transition-colors">
                    <div
                        class="absolute top-0 right-0 w-16 h-16 bg-blue-500/20 rounded-full blur-xl -translate-y-1/2 translate-x-1/2">
                    </div>
                    <div class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Tugas Aktif</div>
                    <div class="flex items-end gap-2">
                        <span class="text-4xl font-extrabold text-white leading-none">{{ $pekerjaans->count() }}</span>
                        <span class="text-blue-400 text-sm font-semibold mb-1">menunggu</span>
                    </div>
                </div>
                <div
                    class="flex-1 md:w-40 bg-white/5 backdrop-blur-xl rounded-2xl p-5 border border-white/10 shadow-2xl relative overflow-hidden group hover:bg-white/10 transition-colors">
                    <div
                        class="absolute top-0 right-0 w-16 h-16 bg-emerald-500/20 rounded-full blur-xl -translate-y-1/2 translate-x-1/2">
                    </div>
                    <div class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Selesai</div>
                    <div class="flex items-end gap-2">
                        <span class="text-4xl font-extrabold text-white leading-none">{{ $tugasSelesai }}</span>
                        <span class="text-emerald-400 text-sm font-semibold mb-1">/ {{ $totalTugas }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-6 py-8 relative z-20 pb-24">

        <!-- Google Calendar Widget -->
        <x-google-calendar-widget />

        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Daftar Pekerjaan Hari Ini</h2>
            <div
                class="bg-blue-50 text-blue-700 border border-blue-200 text-sm font-bold px-5 py-2 rounded-full shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pekerjaans as $p)
                <div
                    class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col justify-between">

                    <div>
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            @php
                                $tenggat = \Carbon\Carbon::parse($p->tanggal)->startOfDay();
                                $hariIni = \Carbon\Carbon::now()->startOfDay();
                                $selisih = $hariIni->diffInDays($tenggat, false);
                            @endphp

                            <div class="flex flex-col items-end gap-1.5">
                                @php
                                    $laporanAktif = $p->laporans()->where('user_id', Auth::id())
                                        ->whereIn('status', ['draft', 'dikirim'])
                                        ->latest()->first();
                                    $hasBefore = false;
                                    $hasAfter = false;
                                    $sedangDivolidasi = false;
                                    
                                    if ($laporanAktif) {
                                        $hasBefore = $laporanAktif->fotos()->where('tipe', 'before')->exists();
                                        $hasAfter = $laporanAktif->fotos()->where('tipe', 'after')->exists();
                                        $sedangDivolidasi = in_array($laporanAktif->status, ['dikirim', 'disetujui']);
                                    }
                                @endphp

                                @if($sedangDivolidasi)
                                    <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-amber-200 uppercase tracking-wider flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu Validasi
                                    </span>
                                @elseif($hasBefore && !$hasAfter)
                                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-blue-200 uppercase tracking-wider">Sedang Berjalan</span>
                                @else
                                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-blue-200 uppercase tracking-wider">Tugas Aktif</span>
                                @endif
                                
                                @if($selisih < 0)
                                    <span class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded flex items-center gap-1 border border-red-100" title="Melewati tenggat waktu">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Terlambat {{ abs($selisih) }} Hari
                                    </span>
                                @elseif($selisih == 0)
                                    <span class="bg-amber-50 text-amber-600 text-[10px] font-bold px-2 py-0.5 rounded flex items-center gap-1 border border-amber-100" title="Harus diselesaikan hari ini">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Batas Waktu Hari Ini!
                                    </span>
                                @elseif($selisih == 1)
                                    <span class="bg-orange-50 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded flex items-center gap-1 border border-orange-100">
                                        Batas Besok
                                    </span>
                                @else
                                    <span class="bg-slate-50 text-slate-500 text-[10px] font-bold px-2 py-0.5 rounded flex items-center gap-1 border border-slate-200">
                                        Batas: {{ $tenggat->format('d M') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h3
                            class="text-lg font-bold text-slate-800 mb-2 leading-snug group-hover:text-blue-700 transition-colors">
                            {{ $p->nama_pekerjaan }}
                        </h3>

                        <div class="flex items-start gap-2 text-sm text-slate-500 mb-6">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="line-clamp-2">{{ $p->lokasi->nama_lokasi ?? 'Lokasi Belum Ditentukan' }}</span>
                        </div>
                    </div>

                    @if($sedangDivolidasi)
                        <div class="w-full flex items-center justify-center gap-2 bg-amber-50 text-amber-700 font-bold py-3.5 px-5 rounded-xl border border-amber-200 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sedang Diverifikasi Admin
                        </div>
                    @else
                        <a href="{{ route('tim.input', ['pekerjaan_id' => $p->id]) }}"
                            class="w-full flex items-center justify-center gap-2 bg-[#0B1120] text-white font-bold py-3.5 px-5 rounded-xl hover:bg-blue-600 transition-colors shadow-md group-hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                            </svg>
                            Buka Laporan Progres
                        </a>
                    @endif
                </div>
            @empty
                <div
                    class="col-span-full bg-white rounded-3xl p-12 border border-slate-200 shadow-sm text-center flex flex-col items-center justify-center">
                    <div
                        class="w-24 h-24 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2 tracking-tight">Semua Tugas Selesai!</h3>
                    <p class="text-slate-500 max-w-md mx-auto text-lg">Anda tidak memiliki daftar pekerjaan baru yang
                        ditugaskan saat ini. Nikmati waktu istirahat Anda.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>

</html>