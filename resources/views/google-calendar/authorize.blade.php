<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Calendar Authorization</title>
    <link rel="icon" href="{{ asset('cv_asa.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Google Calendar</h1>
            <p class="text-gray-600 mt-2">Sinkronisasi Otomatis Reminder</p>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-6 text-sm font-semibold flex items-start gap-2.5">
            <span class="text-base">✅</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mb-6 text-sm font-semibold flex items-start gap-2.5">
            <span class="text-base">❌</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Description -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h2 class="font-semibold text-gray-800 mb-2">✨ Fitur:</h2>
            <ul class="text-sm text-gray-700 space-y-1">
                <li>✅ Event pekerjaan otomatis ke Google Calendar</li>
                <li>✅ Reminder 1 hari & 1 jam sebelumnya</li>
                <li>✅ Sinkronisasi real-time</li>
                <li>✅ Notifikasi email otomatis</li>
            </ul>
        </div>

        <!-- Benefits -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <h2 class="font-semibold text-gray-800 mb-2">💡 Keuntungan:</h2>
            <ul class="text-sm text-gray-700 space-y-1">
                <li>📱 Sinkron di semua device Anda</li>
                <li>🔔 Tidak akan lupa jadwal pekerjaan</li>
                <li>📧 Notifikasi email otomatis</li>
                <li>🔐 Aman dan terenkripsi</li>
            </ul>
        </div>

        <!-- Authorization Button -->
        <form action="{{ route('google-calendar.authorize') }}" method="GET" class="mb-4">
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                Authorize dengan Google
            </button>
        </form>

        <!-- Info -->
        <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-xs text-gray-600">
                Kami memerlukan akses ke Google Calendar Anda untuk sinkronisasi otomatis. Data Anda aman dan terenkripsi.
            </p>
        </div>

        <!-- Already Authorized -->
        @if(auth()->user()->hasGoogleCalendarAuthorization())
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-800">
                ✅ Akun Anda sudah terhubung dengan Google Calendar
            </p>
            <form action="{{ route('google-calendar.revoke') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit"
                    class="w-full text-sm bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg transition-colors">
                    Cabut Akses
                </button>
            </form>
        </div>
        @endif

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>

</html>
