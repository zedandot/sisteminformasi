<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Asa Karya Alam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans flex h-screen overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- Decorative Elements -->
    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-brand-200/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40vw] h-[40vw] bg-emerald-200/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex w-full h-full p-6 lg:p-10 gap-10">
        
        <!-- Left Side: Branding & Info (Hidden on Mobile) -->
        <div class="hidden lg:flex flex-col justify-between w-1/2 p-14 rounded-[2.5rem] bg-slate-900 text-white relative overflow-hidden shadow-2xl shadow-slate-900/40">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-brand-400 via-slate-900 to-slate-900"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-500 rounded-xl flex items-center justify-center font-bold text-lg shadow-lg shadow-brand-500/30">A</div>
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight uppercase">Asa Karya Alam</h1>
                        <p class="text-[10px] text-brand-300 tracking-widest font-medium">INTERNAL FIELD SYSTEM</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 space-y-6">
                <span class="px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-xs font-semibold backdrop-blur-md uppercase tracking-wider">
                    Portal Khusus Karyawan
                </span>
                <h2 class="text-6xl font-black leading-[1.1] tracking-tight">
                    Produktivitas Lapangan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-emerald-300 underline decoration-brand-500/30 decoration-8 underline-offset-8">Tanpa Batas.</span>
                </h2>
                <p class="text-xl text-slate-300 font-medium max-w-lg leading-relaxed mt-4 border-l-4 border-brand-500 pl-4">
                    Satu pintu untuk pengelolaan dokumentasi, validasi GPS, dan pengarsipan Berita Acara (BAP) secara real-time.
                </p>

                <div class="flex items-center gap-6 pt-10">
                    <div class="glass-panel bg-white/5 border-white/10 p-6 rounded-3xl backdrop-blur-md w-1/2 shadow-none">
                        <div class="text-4xl font-bold text-brand-400">80%</div>
                        <div class="text-xs text-slate-400 font-semibold mt-1 tracking-wider">LEBIH CEPAT BUAT BAP</div>
                    </div>
                    <div class="glass-panel bg-white/5 border-white/10 p-6 rounded-3xl backdrop-blur-md w-1/2 shadow-none">
                        <div class="text-4xl font-bold text-emerald-400">Real-time</div>
                        <div class="text-xs text-slate-400 font-semibold mt-1 tracking-wider">VALIDASI GPS LAPANGAN</div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 flex items-center justify-between text-xs text-slate-400 font-medium">
                <p>&copy; 2026 CV Asa Karya Alam</p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Sistem: Online
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center relative z-10">
            <div class="w-full max-w-md space-y-10">
                <div class="text-center lg:text-left space-y-2">
                    <div class="inline-flex lg:hidden items-center justify-center w-14 h-14 bg-brand-600 rounded-2xl text-white font-bold text-2xl mb-4 shadow-xl shadow-brand-500/30">A</div>
                    <h3 class="text-4xl font-extrabold tracking-tight text-slate-900">Selamat Datang</h3>
                    <p class="text-slate-500 font-medium">Masuk untuk melanjutkan ke dashboard panel.</p>
                </div>

                <div class="glass-panel rounded-3xl p-8 sm:p-10 space-y-6">
                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 block p-4 font-medium transition-all duration-300 outline-none" placeholder="nama@asakaryaalam.com" required>
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between ml-1">
                                <label class="text-sm font-bold text-slate-700">Kata Sandi</label>
                                <a href="#" class="text-xs font-semibold text-brand-600 hover:text-brand-700">Lupa sandi?</a>
                            </div>
                            <input type="password" name="password" class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 block p-4 font-medium transition-all duration-300 outline-none" placeholder="••••••••" required>
                            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="w-full text-white bg-slate-900 hover:bg-brand-600 focus:ring-4 focus:outline-none focus:ring-brand-300 font-bold rounded-2xl text-base px-5 py-4 text-center transition-all duration-300 shadow-xl shadow-slate-900/20 hover:shadow-brand-500/30 hover:-translate-y-1">
                            Masuk
                        </button>
                    </form>

                    <div class="text-center pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-500">Hanya untuk staf resmi CV Asa Karya Alam.<br>Akses tidak sah akan dilacak (IP Recorded).</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>