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
            <div class="text-5xl font-black text-red-500 mb-1">3</div>
            <p class="text-sm font-semibold text-slate-600">Melewati 24 Jam</p>
        </div>
    </div>

    <!-- Peringatan -->
    <div class="glass-card rounded-[2rem] p-6 bg-white border-b-4 border-amber-400 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 transition-all group-hover:bg-amber-100"></div>
        <div class="relative z-10">
            <h3 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">Peringatan</h3>
            <div class="text-5xl font-black text-amber-500 mb-1">5</div>
            <p class="text-sm font-semibold text-slate-600">Batas Waktu Hari Ini</p>
        </div>
    </div>

    <!-- Aman -->
    <div class="glass-card rounded-[2rem] p-6 bg-white border-b-4 border-emerald-500 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 transition-all group-hover:bg-emerald-100"></div>
        <div class="relative z-10">
            <h3 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">Aman</h3>
            <div class="text-5xl font-black text-emerald-500 mb-1">16</div>
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
            <span class="px-4 py-2 rounded-full bg-red-50 text-red-600 text-xs font-bold shrink-0 shadow-sm border border-red-100">8 Laporan Mendekati Deadline</span>
        </div>
    </div>

    <div class="space-y-4">
        
        <!-- Item 1: Kritis -->
        <div class="glass-card bg-white border border-red-100 rounded-[2rem] p-6 flex flex-col md:flex-row items-center gap-6 relative shadow-[0_8px_30px_rgb(239,68,68,0.05)] hover:shadow-[0_8px_30px_rgb(239,68,68,0.15)] transition-all duration-300">
            <!-- Icon -->
            <div class="w-14 h-14 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0 border border-red-100">
                <span class="text-xl font-black">!</span>
            </div>
            
            <div class="flex-1">
                <h4 class="text-lg font-bold text-slate-800 mb-1">Maintenance Gate System - Mall Metropolitan</h4>
                <p class="text-sm font-medium text-slate-500">Klien: Rekanan Bisnis Parkir <span class="mx-2 text-slate-300">|</span> Pekerjaan: Mechanical</p>
            </div>

            <div class="text-right shrink-0">
                <div class="text-xs font-bold text-red-500 uppercase tracking-widest mb-1 animate-pulse">Due Date: Hari Ini</div>
                <div class="text-3xl font-black text-slate-800 mb-2 font-mono tabular-nums tracking-tighter">Sisa 04:20:15</div>
                <button class="px-6 py-2 bg-amber-400 hover:bg-amber-500 text-slate-900 font-bold text-sm rounded-full transition-colors shadow-lg shadow-amber-400/30 w-full md:w-auto">
                    Proses BAP
                </button>
            </div>
        </div>

        <!-- Item 2: Warning -->
        <div class="glass-card bg-white border border-amber-100 rounded-[2rem] p-6 flex flex-col md:flex-row items-center gap-6 relative transition-all duration-300">
            <!-- Icon -->
            <div class="w-14 h-14 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center shrink-0 border border-amber-100">
                <span class="text-xl font-black">W</span>
            </div>
            
            <div class="flex-1">
                <h4 class="text-lg font-bold text-slate-800 mb-1">Marka Parkir Zone A-C</h4>
                <p class="text-sm font-medium text-slate-500">Klien: PT. Parkir Jaya <span class="mx-2 text-slate-300">|</span> Pekerjaan: Sipil</p>
            </div>

            <div class="text-right shrink-0">
                <div class="text-xs font-bold text-amber-500 uppercase tracking-widest mb-1">Due Date: Besok</div>
                <div class="text-3xl font-black text-slate-800 mb-2 font-mono tabular-nums tracking-tighter">Sisa 28:10:00</div>
                <button class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-full transition-colors border border-slate-200 w-full md:w-auto">
                    Detail Foto
                </button>
            </div>
        </div>

        <!-- Item 3: Selesai -->
        <div class="glass-card bg-white border border-emerald-100 rounded-[2rem] p-6 flex flex-col md:flex-row items-center gap-6 relative transition-all duration-300 opacity-60 hover:opacity-100">
            <!-- Icon -->
            <div class="w-14 h-14 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <div class="flex-1">
                <h4 class="text-lg font-bold text-slate-800 mb-1 line-through decoration-slate-300">Pengecatan Marka Mall Bekasi</h4>
                <p class="text-sm font-medium text-slate-500">Status: Selesai & Terkirim</p>
            </div>

            <div class="text-right shrink-0 flex flex-col items-end justify-center">
                <div class="text-xs font-bold text-emerald-500 tracking-widest mb-1">Terkirim Tepat Waktu</div>
                <a href="#" class="text-sm font-bold text-brand-500 hover:text-brand-600 underline underline-offset-4 decoration-brand-200 transition-colors">
                    Lihat Arsip PDF
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Floating Notification Warning (Gen Z aesthetic alert) -->
<div class="fixed bottom-10 right-10 z-50">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl shadow-red-900/20 max-w-md animate-[bounce_3s_ease-in-out_infinite]">
        <div class="flex gap-4">
            <div class="w-10 h-10 rounded-full bg-amber-400 text-slate-900 flex items-center justify-center shrink-0 font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-amber-400 uppercase tracking-widest text-xs mb-1">Peringatan Deadline!</h4>
                <p class="text-sm text-slate-300 leading-relaxed font-medium mb-3">
                    Laporan untuk <strong class="text-white">Mall Metropolitan</strong> harus segera dikirim dalam 4 jam ke depan untuk menghindari keterlambatan penagihan.
                </p>
                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg text-xs font-bold transition-colors">Abaikan</button>
                    <button class="px-4 py-2 bg-amber-400 hover:bg-amber-500 text-slate-900 rounded-lg text-xs font-bold transition-colors shadow-lg shadow-amber-400/20">Proses Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
