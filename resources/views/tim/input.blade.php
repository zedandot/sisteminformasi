<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Progres - Tim Lapangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 pb-20">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-blue-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-lg font-bold text-slate-800">Input Progres Proyek</h1>
        </div>
    </header>

    <main class="max-w-md mx-auto px-6 py-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('tim.input.store') }}" method="POST" enctype="multipart/form-data" id="fotoForm" class="space-y-6">
            @csrf
            
            <!-- Hidden inputs for GPS -->
            <input type="hidden" name="gps_latitude" id="gps_latitude" required>
            <input type="hidden" name="gps_longitude" id="gps_longitude" required>

            <!-- Pilih Proyek -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Pilih Proyek Pekerjaan</label>
                <select name="pekerjaan_id" class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block p-3.5 shadow-sm" required>
                    <option value="">-- Pilih Proyek --</option>
                    @foreach($pekerjaans as $pekerjaan)
                        <option value="{{ $pekerjaan->id }}" {{ request('pekerjaan_id') == $pekerjaan->id ? 'selected' : '' }}>
                            {{ $pekerjaan->nama_pekerjaan }} - {{ $pekerjaan->lokasi->nama_lokasi ?? 'Lokasi tidak diketahui' }}
                        </option>
                    @endforeach
                </select>
                @error('pekerjaan_id')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                
                <!-- Foto Before -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 block">Kondisi Awal (Before)</label>
                    <div class="relative group">
                        <input type="file" name="foto_before" id="fotoBeforeInput" accept="image/*" capture="environment" class="hidden">
                        <button type="button" id="triggerBeforeCamera" class="w-full flex flex-col items-center justify-center p-8 border-2 border-dashed border-slate-300 rounded-2xl bg-white hover:bg-slate-50 transition-colors text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="font-bold text-sm">Buka Kamera Before</span>
                        </button>
                        
                        <div id="previewBeforeContainer" class="hidden mt-3 relative rounded-xl overflow-hidden shadow-md">
                            <img id="imageBeforePreview" src="" alt="Preview Before" class="w-full h-40 object-cover">
                            <button type="button" id="retakeBeforeBtn" class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full shadow-lg hover:bg-red-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Foto After -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 block text-blue-700">Hasil Akhir (After)</label>
                    <div class="relative group">
                        <input type="file" name="foto_after" id="fotoAfterInput" accept="image/*" capture="environment" class="hidden">
                        <button type="button" id="triggerAfterCamera" class="w-full flex flex-col items-center justify-center p-8 border-2 border-dashed border-blue-300 rounded-2xl bg-blue-50 hover:bg-blue-100 transition-colors text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="font-bold text-sm">Buka Kamera After</span>
                        </button>
                        
                        <div id="previewAfterContainer" class="hidden mt-3 relative rounded-xl overflow-hidden shadow-md">
                            <img id="imageAfterPreview" src="" alt="Preview After" class="w-full h-40 object-cover">
                            <button type="button" id="retakeAfterBtn" class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full shadow-lg hover:bg-red-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Global Status GPS -->
            <div id="gpsStatus" class="bg-amber-50 text-amber-600 p-3 rounded-lg text-xs font-semibold text-center border border-amber-200">
                Menunggu foto diambil untuk mendapatkan lokasi GPS.
            </div>

            @error('foto')<p class="text-red-500 text-sm text-center font-bold">{{ $message }}</p>@enderror

            <button type="submit" id="submitBtn" class="w-full bg-slate-900 text-white font-bold rounded-xl py-4 hover:bg-blue-600 focus:ring-4 focus:ring-blue-200 transition-all shadow-xl shadow-slate-900/20 mt-8 opacity-50 cursor-not-allowed" disabled>
                Kirim Laporan Progres
            </button>
        </form>
    </main>

    <script>
        const fotoBeforeInput = document.getElementById('fotoBeforeInput');
        const triggerBeforeCamera = document.getElementById('triggerBeforeCamera');
        const previewBeforeContainer = document.getElementById('previewBeforeContainer');
        const imageBeforePreview = document.getElementById('imageBeforePreview');
        const retakeBeforeBtn = document.getElementById('retakeBeforeBtn');

        const fotoAfterInput = document.getElementById('fotoAfterInput');
        const triggerAfterCamera = document.getElementById('triggerAfterCamera');
        const previewAfterContainer = document.getElementById('previewAfterContainer');
        const imageAfterPreview = document.getElementById('imageAfterPreview');
        const retakeAfterBtn = document.getElementById('retakeAfterBtn');

        const gpsStatus = document.getElementById('gpsStatus');
        const latInput = document.getElementById('gps_latitude');
        const lngInput = document.getElementById('gps_longitude');
        const submitBtn = document.getElementById('submitBtn');

        // Before Event Listeners
        triggerBeforeCamera.addEventListener('click', () => fotoBeforeInput.click());
        retakeBeforeBtn.addEventListener('click', () => {
            fotoBeforeInput.value = '';
            previewBeforeContainer.classList.add('hidden');
            triggerBeforeCamera.classList.remove('hidden');
            checkSubmitStatus();
        });
        fotoBeforeInput.addEventListener('change', function(e) {
            if(this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageBeforePreview.src = e.target.result;
                    previewBeforeContainer.classList.remove('hidden');
                    triggerBeforeCamera.classList.add('hidden');
                    getLocation();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // After Event Listeners
        triggerAfterCamera.addEventListener('click', () => fotoAfterInput.click());
        retakeAfterBtn.addEventListener('click', () => {
            fotoAfterInput.value = '';
            previewAfterContainer.classList.add('hidden');
            triggerAfterCamera.classList.remove('hidden');
            checkSubmitStatus();
        });
        fotoAfterInput.addEventListener('change', function(e) {
            if(this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageAfterPreview.src = e.target.result;
                    previewAfterContainer.classList.remove('hidden');
                    triggerAfterCamera.classList.add('hidden');
                    getLocation();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        function checkSubmitStatus() {
            if ((fotoBeforeInput.files.length > 0 || fotoAfterInput.files.length > 0) && latInput.value) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        function getLocation() {
            gpsStatus.innerHTML = '<span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse inline-block"></span> Mendapatkan lokasi...';
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                });
            } else {
                gpsStatus.innerHTML = '<span class="text-red-600">Geolocation tidak didukung browser ini.</span>';
                gpsStatus.className = 'bg-red-50 p-3 rounded-lg text-xs font-semibold text-center border border-red-200';
            }
        }

        function showPosition(position) {
            latInput.value = position.coords.latitude;
            lngInput.value = position.coords.longitude;
            
            gpsStatus.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Lokasi GPS Terverifikasi: ${position.coords.latitude.toFixed(4)}, ${position.coords.longitude.toFixed(4)}
                </span>
            `;
            gpsStatus.className = 'bg-green-50 text-green-700 p-3 rounded-lg text-xs font-semibold text-center border border-green-200';
            checkSubmitStatus();
        }

        function showError(error) {
            let msg = "";
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    msg = "Izin lokasi ditolak.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    msg = "Informasi lokasi tidak tersedia.";
                    break;
                case error.TIMEOUT:
                    msg = "Waktu pencarian lokasi habis.";
                    break;
                default:
                    msg = "Terjadi kesalahan yang tidak diketahui.";
                    break;
            }
            gpsStatus.innerHTML = msg + ' (Wajib untuk upload)';
            gpsStatus.className = 'bg-red-50 text-red-600 p-3 rounded-lg text-xs font-semibold text-center border border-red-200';
            checkSubmitStatus();
        }
    </script>
</body>
</html>
