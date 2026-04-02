@extends('layouts.admin')

@section('title', 'Ringkasan Operasional Lapangan')
@section('subtitle', 'Pantau aktivitas proyek dan kinerja tim secara real-time.')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    
    <!-- Stat Card 1 -->
    <div class="glass-card rounded-[2rem] p-6 bg-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-brand-50 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3 transition-all group-hover:bg-brand-100"></div>
        <div class="relative z-10 flex flex-col h-full justify-between gap-4">
            <h3 class="text-sm font-semibold text-slate-500">Proyek Aktif</h3>
            <div>
                <div class="text-5xl font-extrabold text-slate-800 tracking-tight">24</div>
                <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-emerald-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    &uarr; 12% dari bulan lalu
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="glass-card rounded-[2rem] p-6 bg-white relative overflow-hidden group border border-red-100 shadow-red-500/5">
        <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3 transition-all group-hover:bg-red-100"></div>
        <div class="relative z-10 flex flex-col h-full justify-between gap-4">
            <h3 class="text-sm font-semibold text-slate-500">BAP Menunggu</h3>
            <div>
                <div class="text-5xl font-extrabold text-red-500 tracking-tight">08</div>
                <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-red-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    Deadline < 48 jam
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="glass-card rounded-[2rem] p-6 bg-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-brand-50 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3 transition-all group-hover:bg-brand-100"></div>
        <div class="relative z-10 flex flex-col h-full justify-between gap-4">
            <h3 class="text-sm font-semibold text-slate-500">Tim Lapangan</h3>
            <div>
                <div class="text-5xl font-extrabold text-slate-800 tracking-tight">12</div>
                <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-slate-400">
                    Wilayah Jabodetabek
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Card 4 (Revenue) -->
    <div class="rounded-[2rem] p-6 bg-slate-900 border border-slate-800 shadow-2xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
        <!-- Glow effects -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-500/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3"></div>
        
        <div class="relative z-10 flex flex-col h-full justify-between gap-4">
            <div class="flex justify-between items-center">
                <h3 class="text-sm font-bold tracking-wider text-brand-300 uppercase">Total Revenue</h3>
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border border-white/5">
                    <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl lg:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300 tracking-tight">Rp 452.000.000</div>
                <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-emerald-400">
                    Estimasi Penagihan Aktif
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Aktivitas Lapangan Terbaru -->
<div class="mt-8 bg-white rounded-[2.5rem] p-8 glass-card">
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-lg font-bold tracking-tight text-slate-800">Aktivitas Lapangan Terbaru</h3>
        <a href="#" class="text-sm font-semibold text-brand-500 hover:text-brand-600 flex items-center gap-1 transition-colors">
            Lihat Semua Aktivitas <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="pb-4 text-xs font-bold tracking-wider text-slate-400 uppercase w-1/3">Lokasi / Proyek</th>
                    <th class="pb-4 text-xs font-bold tracking-wider text-slate-400 uppercase">Ketua Tim</th>
                    <th class="pb-4 text-xs font-bold tracking-wider text-slate-400 uppercase">Waktu Kerja</th>
                    <th class="pb-4 text-xs font-bold tracking-wider text-slate-400 uppercase text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                
                <!-- Row 1 -->
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="py-5 pr-4">
                        <div class="font-bold text-slate-800 mb-1">Marka Parkir Area B</div>
                        <div class="text-xs text-slate-500 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span> Maintenance Sipil &bull; Mall Metropolitan, Bekasi
                        </div>
                    </td>
                    <td class="py-5 px-4 text-sm font-semibold text-slate-700">Ahmad Subarjo</td>
                    <td class="py-5 px-4 text-sm font-semibold text-slate-700">22:00 - 03:00 WIB</td>
                    <td class="py-5 text-right pl-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600 border border-emerald-200">
                            SELESAI
                        </span>
                    </td>
                </tr>

                <!-- Row 2 -->
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="py-5 pr-4">
                        <div class="font-bold text-slate-800 mb-1">Perbaikan Gate System</div>
                        <div class="text-xs text-slate-500 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Mechanical Engineering &bull; Summarecon Mall Bekasi
                        </div>
                    </td>
                    <td class="py-5 px-4 text-sm font-semibold text-slate-700">Dedi Irawan</td>
                    <td class="py-5 px-4 text-sm font-semibold text-slate-700">00:00 - 05:00 WIB</td>
                    <td class="py-5 text-right pl-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-600 border border-amber-200">
                            TINJAUAN BAP
                        </span>
                    </td>
                </tr>

                <!-- Row 3 -->
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="py-5 pr-4">
                        <div class="font-bold text-slate-800 mb-1">Renovasi Hunian Tipe 45</div>
                        <div class="text-xs text-slate-500 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span> Jasa Renovasi &bull; Harapan Indah, Bekasi
                        </div>
                    </td>
                    <td class="py-5 px-4 text-sm font-semibold text-slate-700">Suryono</td>
                    <td class="py-5 px-4 text-sm font-semibold text-slate-700">08:00 - 16:00 WIB</td>
                    <td class="py-5 text-right pl-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brand-100 text-brand-600 border border-brand-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse"></span> BERJALAN
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

@endsection
