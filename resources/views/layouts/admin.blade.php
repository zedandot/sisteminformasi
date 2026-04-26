<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Asa Karya Alam') - Internal Field System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans flex h-screen overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- Sidebar -->
    <aside class="w-72 bg-[#0A192F] text-white flex flex-col transition-all duration-300 relative z-20 shadow-2xl shadow-brand-900/20">
        <!-- Logo Area -->
        <div class="h-24 flex items-center px-8 border-b border-white/10">
            <div>
                <h1 class="text-brand-500 font-extrabold text-xl tracking-tight uppercase leading-none">Asa Karya Alam</h1>
                <p class="text-[10px] text-slate-400 font-medium tracking-widest mt-1">Kontraktor & Supplier</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-2">
            
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/dashboard') ? 'bg-brand-600/20 text-brand-500 font-semibold' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->is('admin/dashboard') ? 'text-brand-500' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Beranda
            </a>

            <a href="/admin/monitoring" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/monitoring') ? 'bg-brand-600/20 text-brand-500 font-semibold border-l-4 border-brand-500' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <svg class="w-5 h-5 {{ request()->is('admin/monitoring') ? 'text-brand-500' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Monitoring Proyek
            </a>

            <a href="/admin/bap" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/bap') ? 'bg-brand-600/20 text-brand-500 font-semibold border-l-4 border-brand-500' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <svg class="w-5 h-5 {{ request()->is('admin/bap') ? 'text-brand-500' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Pelacakan BAP
            </a>

            <a href="/admin/lokasi" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/lokasi') ? 'bg-brand-600/20 text-brand-500 font-semibold border-l-4 border-brand-500' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <svg class="w-5 h-5 {{ request()->is('admin/lokasi') ? 'text-brand-500' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Lokasi Tim Lapangan
            </a>
            
        </nav>

        <!-- User Profile -->
        <div class="p-6">
            <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-3 hover:bg-white/10 transition-colors cursor-pointer border border-white/5">
                <div class="w-10 h-10 rounded-full bg-brand-500/20 flex items-center justify-center text-brand-500 font-bold border border-brand-500/50">
                    A
                </div>
                <div>
                    <p class="text-xs text-slate-400">Masuk sebagai</p>
                    <p class="text-sm font-semibold text-white">Admin Utama</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-xs text-slate-500 px-2">
                <span>Status Operasional</span>
                <span class="flex items-center gap-1 text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> 12 Tim Aktif
                </span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col bg-slate-50 relative">
        <!-- Floating shapes for aesthetic -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-emerald-500/5 rounded-full blur-3xl translate-y-1/3 -translate-x-1/3 pointer-events-none"></div>

        <!-- Topbar -->
        <header class="h-24 px-10 flex items-center justify-between z-10 glass-panel border-x-0 border-t-0 backdrop-blur-2xl bg-white/60 relative">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-800">@yield('title')</h2>
                <p class="text-sm text-slate-500 mt-1 font-medium">@yield('subtitle', 'Sistem Informasi Manajemen Lapangan')</p>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Status Badge -->
                <div class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold flex items-center gap-2 border border-emerald-100 shadow-sm shadow-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping absolute relative inline-flex">
                        <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Sistem Live
                </div>
                
                <!-- Notification -->
                <button class="relative p-2 text-slate-400 hover:text-brand-600 transition-colors bg-white rounded-full shadow-sm hover:shadow-md border border-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-10 z-10 relative">
            <div class="max-w-7xl mx-auto space-y-8">
                @yield('content')
            </div>
        </div>
    </main>

</body>
</html>
