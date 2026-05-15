<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Asa Karya Alam') - Internal Field System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans flex h-screen overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity opacity-0"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-72 bg-[#0A192F] text-white flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0 z-50 shadow-2xl shadow-brand-900/20">
        <!-- Logo Area -->
        <div class="h-20 lg:h-24 flex items-center justify-between px-6 border-b border-white/10">
            <div class="flex items-center gap-4">
                <img src="{{ asset('cv_asa.png') }}" alt="Logo CV Asa Karya Alam" class="h-12 w-12 lg:h-14 lg:w-14 scale-125 object-contain drop-shadow-lg shrink-0">
                <div class="flex flex-col justify-center whitespace-nowrap">
                    <h1 class="text-white font-extrabold text-sm lg:text-base tracking-tight uppercase leading-none">Asa Karya Alam</h1>
                    <p class="text-[9px] text-slate-400 font-medium tracking-widest mt-1">Kontraktor & Supplier</p>
                </div>
            </div>
            <button id="close-sidebar-btn" class="lg:hidden text-slate-400 hover:text-white p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-8 space-y-2 px-3">
            
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('admin/dashboard') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->is('admin/dashboard') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Beranda
            </a>

            <a href="/admin/pekerjaan" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('admin/pekerjaan*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->is('admin/pekerjaan*') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Manajemen Proyek
            </a>

            <a href="/admin/monitoring" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('admin/monitoring') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->is('admin/monitoring') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Monitoring Proyek
            </a>

            <a href="/admin/bap" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('admin/bap') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->is('admin/bap') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Pelacakan BAP
            </a>

            <a href="/admin/lokasi" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('admin/lokasi') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->is('admin/lokasi') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Lokasi Tim Lapangan
            </a>
            
        </nav>

        <!-- User Profile -->
        <div class="p-6 border-t border-white/5">
            <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-3 hover:bg-white/10 transition-colors cursor-pointer border border-white/5">
                <div class="w-10 h-10 rounded-full bg-brand-500/20 flex items-center justify-center text-brand-500 font-bold border border-brand-500/50 uppercase shrink-0">
                    {{ substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs text-slate-400 uppercase tracking-widest truncate">Administrator</p>
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
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
    <main class="flex-1 flex flex-col bg-slate-50 relative w-full overflow-hidden">
        <!-- Floating shapes for aesthetic -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-emerald-500/5 rounded-full blur-3xl translate-y-1/3 -translate-x-1/3 pointer-events-none"></div>

        <!-- Topbar -->
        <header class="h-20 lg:h-24 px-4 lg:px-10 flex items-center justify-between z-30 glass-panel border-x-0 border-t-0 backdrop-blur-2xl bg-white/60 relative">
            <div class="flex items-center gap-3 lg:gap-0">
                <button id="open-sidebar-btn" class="lg:hidden p-2 -ml-2 text-slate-500 hover:text-brand-600 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <h2 class="text-lg lg:text-2xl font-bold tracking-tight text-slate-800 line-clamp-1">@yield('title')</h2>
                    <p class="hidden lg:block text-sm text-slate-500 mt-1 font-medium">@yield('subtitle', 'Sistem Informasi Manajemen Lapangan')</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 lg:gap-6">
                <!-- Status Badge -->
                <div class="hidden sm:flex px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold items-center gap-2 border border-emerald-100 shadow-sm shadow-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping absolute relative inline-flex">
                        <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Sistem Live
                </div>
                
                <!-- Notification -->
                @php 
                    $unreadNotif = \App\Models\Notifikasi::where('user_id', Auth::guard('admin')->id())
                                    ->where('status_baca', false)
                                    ->latest()->take(5)->get();
                                    
                    $hariIni = \Carbon\Carbon::now()->startOfDay();
                    $pekerjaanKritis = \App\Models\Pekerjaan::where('status', '!=', 'Selesai')
                                    ->whereDate('tanggal', '<=', $hariIni)
                                    ->get();
                                    
                    $totalNotif = $unreadNotif->count() + $pekerjaanKritis->count();
                @endphp
                <div class="relative group">
                    <button class="relative p-2 text-slate-400 hover:text-brand-600 transition-colors bg-white rounded-full shadow-sm hover:shadow-md border border-slate-100">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if($totalNotif > 0)
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div class="absolute right-[-40px] sm:right-0 top-full pt-2 w-[300px] sm:w-80 hidden group-hover:block z-50 transform origin-top-right transition-all">
                        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 py-2">
                            <div class="px-4 py-3 border-b border-slate-50 flex justify-between items-center bg-slate-50/50 rounded-t-2xl">
                                <span class="font-bold text-slate-800 text-sm">Notifikasi & Peringatan</span>
                                @if($totalNotif > 0)
                                <span class="bg-red-100 text-red-600 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $totalNotif }}</span>
                                @endif
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                
                                <!-- Tenggat Waktu Alerts (Dynamic) -->
                                @foreach($pekerjaanKritis as $pk)
                                    @php 
                                        $selisih = $hariIni->diffInDays(\Carbon\Carbon::parse($pk->tanggal)->startOfDay(), false); 
                                    @endphp
                                    <a href="{{ route('admin.pekerjaan') }}" class="block px-4 py-3 bg-red-50/30 hover:bg-red-50 border-b border-red-50/50 transition-colors group/item">
                                        <div class="flex items-start gap-2">
                                            <div class="mt-0.5 w-2 h-2 rounded-full bg-red-500 animate-pulse shrink-0"></div>
                                            <div>
                                                <p class="text-sm text-slate-700 leading-snug font-semibold group-hover/item:text-red-700 transition-colors">
                                                    Peringatan Tenggat: Proyek "{{ $pk->nama_pekerjaan }}" 
                                                    {{ $selisih < 0 ? 'telah terlambat ' . abs($selisih) . ' hari!' : 'batas waktunya adalah HARI INI!' }}
                                                </p>
                                                <p class="text-[10px] text-red-400 font-bold uppercase tracking-wider mt-1">Sistem Otomatis</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                                <!-- Regular Notifications -->
                                @forelse($unreadNotif as $notif)
                                    <a href="{{ route('admin.notifikasi.read', $notif->id) }}" class="block px-4 py-3 hover:bg-slate-50 border-b border-slate-50 last:border-0 transition-colors group/item">
                                        <p class="text-sm text-slate-700 leading-snug font-medium group-hover/item:text-brand-600 transition-colors">{{ $notif->pesan }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($notif->tanggal)->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @empty
                                    @if($pekerjaanKritis->count() == 0)
                                    <div class="px-6 py-8 text-center flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                        </div>
                                        <p class="text-slate-500 text-sm font-medium">Belum ada notifikasi baru.</p>
                                    </div>
                                    @endif
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="m-0 sm:ml-2 lg:ml-4">
                    @csrf
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 sm:px-4 sm:py-2 rounded-lg text-sm font-semibold transition-all border border-red-200 shadow-sm flex items-center gap-2" title="Keluar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-4 lg:p-10 z-10 relative">
            <div class="max-w-7xl mx-auto space-y-6 lg:space-y-8">
                @yield('content')
            </div>
        </div>
    </main>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const openBtn = document.getElementById('open-sidebar-btn');
            const closeBtn = document.getElementById('close-sidebar-btn');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                setTimeout(() => {
                    sidebarOverlay.classList.remove('opacity-0');
                }, 10);
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('opacity-0');
                setTimeout(() => {
                    sidebarOverlay.classList.add('hidden');
                }, 300);
            }

            if(openBtn) openBtn.addEventListener('click', openSidebar);
            if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if(sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
        });
    </script>
</body>
</html>
