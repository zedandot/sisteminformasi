<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Asa Karya Alam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center text-slate-800 selection:bg-blue-200 relative overflow-hidden">
    
    <!-- Exact Decorative Blur from Home Page -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-blue-400/20 blur-[100px] rounded-full -z-10 pointer-events-none"></div>

    <!-- Login Card -->
    <div class="relative z-10 w-full max-w-[420px] px-4">
        
        <div class="bg-white/90 backdrop-blur-2xl p-8 sm:p-10 rounded-[2.5rem] shadow-2xl shadow-blue-900/10 border border-white">
            
            <div class="flex flex-col items-center mb-10 text-center">
                <!-- Using the same blue from the home page (bg-blue-600) -->
                <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mb-6 shadow-md shadow-blue-200 text-white">
                    <i data-lucide="building-2" class="w-7 h-7"></i>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Portal Internal</h1>
                <p class="text-sm text-slate-500 font-medium">
                    Sistem Manajemen Lapangan<br><span class="font-bold text-slate-700">CV Asa Karya Alam</span>
                </p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 ml-1">EMAIL PERUSAHAAN</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block pl-12 p-3.5 font-medium transition-all outline-none" placeholder="nama@asakaryaalam.com" required>
                    </div>
                    @error('email')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center px-1">
                        <label class="block text-xs font-bold text-slate-700">KATA SANDI</label>
                        <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">Lupa sandi?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="password" name="password" class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block pl-12 p-3.5 font-medium transition-all outline-none" placeholder="••••••••" required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer">
                            <i data-lucide="eye-off" class="w-5 h-5 text-slate-400 hover:text-slate-600 transition-colors"></i>
                        </div>
                    </div>
                    @error('password')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all mt-8 shadow-md shadow-blue-200">
                    Masuk ke Sistem
                </button>
            </form>
            
            <div class="mt-8 text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sistem Internal &bull; Secured</p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>