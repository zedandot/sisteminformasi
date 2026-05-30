<!-- Google Calendar Status Widget -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Google Calendar</h3>
                <p class="text-sm text-gray-600">Sinkronisasi Reminder Pekerjaan</p>
            </div>
        </div>
        <div class="text-right">
            @if(auth()->user()->hasGoogleCalendarAuthorization())
            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                ✅ Terhubung
            </span>
            @else
            <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                ⚠️ Belum Terhubung
            </span>
            @endif
        </div>
    </div>

    @if(auth()->user()->hasGoogleCalendarAuthorization())
    <div class="grid grid-cols-3 gap-4 mb-4">
        <div class="bg-blue-50 rounded-lg p-3 text-center">
            <p class="text-sm text-gray-600">Event Tersinkronisasi</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ auth()->user()->pekerjaans()->whereNotNull('google_event_id')->count() }}
            </p>
        </div>
        <div class="bg-green-50 rounded-lg p-3 text-center">
            <p class="text-sm text-gray-600">Reminder Dikirim</p>
            <p class="text-2xl font-bold text-green-600">
                {{ auth()->user()->pekerjaans()->where('reminder_sent', true)->count() }}
            </p>
        </div>
        <div class="bg-orange-50 rounded-lg p-3 text-center">
            <p class="text-sm text-gray-600">Pending Sync</p>
            <p class="text-2xl font-bold text-orange-600">
                {{ auth()->user()->pekerjaans()->where('sync_status', 'pending')->count() }}
            </p>
        </div>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('google-calendar.show') }}"
            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-center text-sm font-medium transition-colors">
            Kelola Koneksi
        </a>
        <form action="{{ route('google-calendar.revoke') }}" method="POST" class="flex-1">
            @csrf
            <button type="submit"
                class="w-full bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Putuskan
            </button>
        </form>
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
        <p class="text-sm text-yellow-800 mb-3">
            🔔 <strong>Aktifkan Google Calendar</strong> untuk mendapatkan reminder otomatis untuk setiap pekerjaan Anda.
        </p>
    </div>

    <a href="{{ route('google-calendar.show') }}"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg text-center text-sm font-medium transition-colors block">
        🔗 Hubungkan dengan Google Calendar
    </a>
    @endif
</div>

<!-- Sync Status untuk setiap Pekerjaan -->
<div class="mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Sinkronisasi Pekerjaan</h3>
    <div class="space-y-2 max-h-64 overflow-y-auto">
        @forelse(auth()->user()->pekerjaans()->orderByDesc('created_at')->limit(5)->get() as $pekerjaan)
        <div class="bg-white rounded-lg p-4 border-l-4 {{ match($pekerjaan->sync_status) {
            'synced' => 'border-green-500 bg-green-50',
            'failed' => 'border-red-500 bg-red-50',
            'pending' => 'border-yellow-500 bg-yellow-50',
            default => 'border-gray-500',
        } }}">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="font-semibold text-gray-800">{{ $pekerjaan->nama_pekerjaan }}</p>
                    <p class="text-sm text-gray-600">{{ $pekerjaan->tanggal->format('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block {{ match($pekerjaan->sync_status) {
                        'synced' => 'bg-green-200 text-green-800',
                        'failed' => 'bg-red-200 text-red-800',
                        'pending' => 'bg-yellow-200 text-yellow-800',
                        default => 'bg-gray-200 text-gray-800',
                    } }} px-3 py-1 rounded-full text-xs font-semibold">
                        {{ $pekerjaan->sync_status_badge }}
                    </span>
                </div>
            </div>
            @if($pekerjaan->sync_error)
            <p class="text-xs text-red-600 mt-2">{{ $pekerjaan->sync_error }}</p>
            @endif
        </div>
        @empty
        <p class="text-gray-500 text-center py-4">Tidak ada pekerjaan</p>
        @endforelse
    </div>
</div>
