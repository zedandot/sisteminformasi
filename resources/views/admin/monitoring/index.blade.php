@extends('layouts.admin')

@section('title', 'Monitoring & Validasi Lapangan')
@section('subtitle', 'Pantau persebaran tim dan validasi dokumentasi proyek sesuai koordinat GPS.')

@section('content')

<!-- Tabs Navigation -->
<div class="flex gap-4 border-b border-slate-200 mb-8" id="tabs-nav">
    <button class="px-6 py-3 font-bold text-brand-600 border-b-2 border-brand-500 hover:text-brand-700 transition-colors">
        Lokasi Tim Lapangan
    </button>
    <button class="px-6 py-3 font-bold text-slate-400 border-b-2 border-transparent hover:text-slate-600 transition-colors">
        Validasi Foto Proyek
    </button>
</div>

<!-- SECTION 1: MAP LOKASI TIM -->
<div class="space-y-6 block">
    
    <!-- Map Container -->
    <div class="bg-white rounded-[2rem] p-4 glass-card relative h-[500px] overflow-hidden flex flex-col border border-slate-100 p-0">
        <!-- Subtle Grid Pattern Background -->
        <div class="absolute inset-0 bg-[#f8fafc]" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 32px 32px; opacity: 0.5;"></div>
        
        <!-- Big Map Title Watermark -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.03]">
            <h2 class="text-9xl font-black uppercase rotate-[-10deg] tracking-tighter">JABODETABEK</h2>
        </div>

        <!-- Live Status indicator top right -->
        <div class="absolute top-6 right-6 z-10 flex items-center gap-2 bg-white/80 backdrop-blur-md px-4 py-2 rounded-full border border-slate-200 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping absolute"></span>
            <span class="w-2 h-2 rounded-full bg-emerald-500 relative z-10"></span>
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Sistem Live</span>
        </div>

        <!-- Map Pins (Dummy Gen-Z style pulsing dots) -->
        <div class="absolute top-[35%] left-[45%] w-4 h-4 bg-brand-500 rounded-full shadow-[0_0_15px_rgba(59,130,246,0.6)] group cursor-pointer hover:scale-150 transition-transform">
            <span class="absolute inset-0 rounded-full bg-brand-500 animate-ping opacity-75"></span>
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1.5 bg-slate-900 text-white text-xs font-bold rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity">
                Maintenance Sipil (6 Tim)
            </div>
        </div>

        <div class="absolute top-[50%] left-[55%] w-4 h-4 bg-amber-400 rounded-full shadow-[0_0_15px_rgba(251,191,36,0.6)] group cursor-pointer hover:scale-150 transition-transform">
            <span class="absolute inset-0 rounded-full bg-amber-400 animate-ping opacity-75"></span>
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1.5 bg-slate-900 text-white text-xs font-bold rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity">
                Mechanical Engineering (6 Tim)
            </div>
        </div>

        <!-- Filter Tags Bottom Left -->
        <div class="absolute bottom-6 left-6 z-10 flex gap-3">
            <div class="bg-white px-4 py-2 rounded-full shadow-lg border border-slate-100 flex items-center gap-2 cursor-pointer hover:border-brand-500 transition-colors">
                <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                <span class="text-xs font-bold text-slate-700">Maintenance Sipil</span>
            </div>
            <div class="bg-white px-4 py-2 rounded-full shadow-lg border border-slate-100 flex items-center gap-2 cursor-pointer hover:border-amber-400 transition-colors">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                <span class="text-xs font-bold text-slate-700">Mechanical Engineering</span>
            </div>
        </div>
    </div>

    <!-- Summary below map -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 glass-card bg-white rounded-[2rem] p-8 border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Sebaran Tim Wilayah Operasional</h3>
            
            <div class="space-y-6">
                <!-- Bar 1 -->
                <div>
                    <div class="flex justify-between text-sm font-semibold mb-2">
                        <span class="text-slate-600">Bekasi (Kantor Pusat)</span>
                        <span class="text-slate-800 font-bold">6 Tim</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-brand-500 h-3 rounded-full" style="width: 50%"></div>
                    </div>
                </div>
                <!-- Bar 2 -->
                <div>
                    <div class="flex justify-between text-sm font-semibold mb-2">
                        <span class="text-slate-600">Jakarta & Tangerang</span>
                        <span class="text-slate-800 font-bold">6 Tim</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-amber-400 h-3 rounded-full" style="width: 50%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden group hover:-translate-y-1 transition-transform border border-slate-800 shadow-2xl flex flex-col justify-center">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-bold tracking-widest text-brand-400 uppercase mb-2">Total Personil</h3>
                    <div class="text-5xl font-black mb-2 tracking-tight">48 <span class="text-2xl font-semibold text-slate-400 ml-1">Staff</span></div>
                    <p class="text-xs font-medium text-slate-500">Aktif di 12 titik lokasi Jabodetabek</p>
                </div>
                <!-- Abstract Map Icon -->
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md">
                    <svg class="w-8 h-8 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECTION 2: VALIDASI FOTO (Design placeholder for the tab content) -->
<div class="space-y-6 hidden mt-8">
    <div class="flex items-center justify-between bg-white glass-card rounded-3xl p-6 border border-slate-100">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Review Dokumentasi Pekerjaan</h3>
            <p class="text-sm font-medium text-slate-500 mt-1">ID Proyek: <span class="text-brand-600 font-bold uppercase">#BEK-001A</span></p>
        </div>
        <button class="px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-full shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-0.5">Setujui BAP</button>
    </div>

    <!-- Before After Comparison Wrapper -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Before Image Card -->
        <div class="bg-white rounded-[2rem] p-6 glass-card border-x-0 border-t-0 border-b-4 border-red-500 border-x border-t border-slate-100 relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-red-500">Foto Sebelum (Before)</h4>
                <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold">Verified</span>
            </div>
            
            <div class="w-full aspect-[4/3] bg-slate-100 rounded-2xl relative overflow-hidden group">
                <!-- Inner Image Placeholder -->
                <div class="absolute inset-0 bg-slate-200 border-2 border-dashed border-slate-300 rounded-2xl m-2 flex flex-col items-center justify-center text-slate-400 group-hover:bg-slate-300 transition-colors">
                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="text-xs font-bold uppercase tracking-widest">Gambar Diunggah Oleh Tim</span>
                </div>
                
                <!-- GPS Overlay Widget -->
                <div class="absolute bottom-4 left-4 bg-slate-900/80 backdrop-blur-md rounded-xl p-3 border border-white/10 shadow-lg flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-brand-500/20 flex items-center justify-center text-brand-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-mono text-emerald-400 font-semibold tracking-wider">GPS: -6.234, 106.989</div>
                        <div class="text-[10px] text-slate-300 mt-0.5">20:15 WIB &bull; 02 Apr 2026</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- After Image Card -->
        <div class="bg-white rounded-[2rem] p-6 glass-card border-x-0 border-t-0 border-b-4 border-emerald-500 border border-slate-100 relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-emerald-500">Foto Sesudah (After)</h4>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse block"></span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Menunggu Unggahan...</span>
                </div>
            </div>
            
            <div class="w-full aspect-[4/3] bg-slate-50 rounded-2xl relative overflow-hidden border-2 border-dashed border-emerald-200">
                <div class="absolute inset-0 flex flex-col items-center justify-center text-emerald-500/50">
                    <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="text-xs font-bold italic">Menunggu update progres lapangan...</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
