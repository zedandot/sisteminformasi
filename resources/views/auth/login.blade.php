<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Asa Karya Alam</title>
    <link rel="icon" href="{{ asset('cv_asa.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative font-sans overflow-hidden bg-[#0f172a]">
    
    <!-- Full-screen background image -->
    <img src="{{ asset('images/login_bg.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-90" style="z-index: 1;" alt="Construction Background">
    
    <!-- Dark overlay to make text readable -->
    <div class="absolute inset-0" style="background-color: rgba(15, 23, 42, 0.5); z-index: 2;"></div>

    <!-- Glassmorphism Login Card -->
    <div class="relative w-full max-w-md px-6" style="z-index: 10;">
        <div class="rounded-3xl p-8 sm:p-10 shadow-2xl" style="background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.2);">
            
            <div class="flex flex-col items-center mb-8 text-center">
                <!-- Logo -->
                <img src="{{ asset('cv_asa.png') }}" alt="Logo CV Asa Karya Alam" class="h-20 object-contain mb-4 drop-shadow-lg">
                <h1 class="text-3xl font-bold text-white mb-1 tracking-tight">Portal Internal</h1>
                <p class="text-sm text-slate-200">
                    Sistem Manajemen Lapangan
                </p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-200 ml-1">Email Perusahaan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="user" class="w-5 h-5 text-slate-300"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-400 block pl-12 p-3.5 transition-all outline-none placeholder-slate-400" style="background-color: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.1);" placeholder="nama@asakaryaalam.com" required>
                    </div>
                    @error('email')<p class="text-red-400 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-200 ml-1">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-slate-300"></i>
                        </div>
                        <input type="password" name="password" id="password" class="w-full text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-400 block pl-12 p-3.5 transition-all outline-none placeholder-slate-400" style="background-color: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.1);" placeholder="••••••••" required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer" id="togglePassword">
                            <i data-lucide="eye-off" id="eyeIcon" class="w-5 h-5 text-slate-300 hover:text-white transition-colors"></i>
                        </div>
                    </div>
                    @error('password')<p class="text-red-400 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between mt-2 mb-2">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" class="w-4 h-4 rounded text-blue-500 focus:ring-blue-500" style="background-color: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.2);">
                        <label for="remember" class="ml-2 text-xs font-medium text-slate-200">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-500 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all shadow-lg shadow-blue-900">
                    Login Sistem
                </button>
            </form>
            
            <div class="mt-8 text-center pt-6" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">
                <p class="text-xs font-medium text-slate-300 tracking-wide">
                    Sistem Internal &bull; Secured
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            if (type === 'password') {
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        });
    </script>
</body>
</html>