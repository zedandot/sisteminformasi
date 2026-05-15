<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Progres - Tim Lapangan</title>
    <link rel="icon" href="{{ asset('cv_asa.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 pb-20 relative">

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-[100] hidden flex flex-col items-center justify-center text-white">
        <svg class="animate-spin -ml-1 mr-3 h-12 w-12 text-blue-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <h3 class="text-xl font-bold">Mengunggah Laporan...</h3>
        <p class="text-slate-300 text-sm mt-2">Sedang memproses dan mengompresi foto.</p>
    </div>

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

        @php
            $hasBefore = false;
            $hasAfter = false;
            if (isset($laporan)) {
                $hasBefore = $laporan->fotos->where('tipe', 'before')->count() > 0;
                $hasAfter = $laporan->fotos->where('tipe', 'after')->count() > 0;
            }
        @endphp

        <form action="{{ route('tim.input.store') }}" method="POST" enctype="multipart/form-data" id="fotoForm" class="space-y-6">
            @csrf
            
            <!-- Hidden inputs for GPS -->
            <input type="hidden" name="gps_latitude" id="gps_latitude" required>
            <input type="hidden" name="gps_longitude" id="gps_longitude" required>

            <!-- Pilih Proyek -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Pilih Proyek Pekerjaan</label>
                <select name="pekerjaan_id" id="pekerjaanSelect" class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block p-3.5 shadow-sm" required>
                    <option value="">-- Pilih Proyek --</option>
                    @foreach($pekerjaans as $pekerjaan)
                        <option value="{{ $pekerjaan->id }}" {{ request('pekerjaan_id') == $pekerjaan->id ? 'selected' : '' }}>
                            {{ $pekerjaan->nama_pekerjaan }} - {{ $pekerjaan->lokasi->nama_lokasi ?? 'Lokasi tidak diketahui' }}
                        </option>
                    @endforeach
                </select>
                @error('pekerjaan_id')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
            </div>

            @if(request('pekerjaan_id'))
                <!-- Global Status GPS -->
                <div id="gpsStatus" class="bg-amber-50 text-amber-600 p-3 rounded-lg text-xs font-semibold text-center border border-amber-200">
                    Menunggu foto diambil untuk mendapatkan lokasi GPS.
                </div>

                @if(!$hasBefore)
                    <!-- Tahap 1: Mulai Pekerjaan -->
                    <button type="button" id="btnMulai" class="w-full bg-blue-600 text-white font-bold rounded-xl py-4 shadow-lg hover:bg-blue-700 transition-colors">
                        Mulai Pekerjaan
                    </button>

                    <div id="beforeSection" class="hidden space-y-4 mt-6">
                        <h3 class="font-bold text-slate-800">Foto Kondisi Awal (Before)</h3>
                        <p class="text-sm text-slate-500 mb-2">Pilih atau ambil hingga 4 foto kondisi awal pekerjaan.</p>
                        <div class="grid grid-cols-2 gap-4">
                            @for($i=1; $i<=4; $i++)
                                <div class="relative group">
                                    <input type="file" name="foto_before[]" id="before_{{$i}}" accept="image/*" capture="environment" class="hidden file-input" data-type="before" data-index="{{$i}}">
                                    <button type="button" onclick="document.getElementById('before_{{$i}}').click()" class="w-full flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-300 rounded-xl bg-white hover:bg-slate-50 h-32">
                                        <svg class="h-8 w-8 text-slate-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                        <span class="text-xs font-bold text-slate-500">Foto {{$i}}</span>
                                    </button>
                                    <img id="preview_before_{{$i}}" src="" class="hidden absolute inset-0 w-full h-full object-cover rounded-xl shadow-sm z-10">
                                    <button type="button" onclick="removeFoto('before', {{$i}})" id="remove_before_{{$i}}" class="hidden absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-full z-20 shadow">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @endfor
                        </div>
                        
                        <button type="submit" id="submitBefore" class="w-full bg-slate-900 text-white font-bold rounded-xl py-4 mt-6 opacity-50 cursor-not-allowed" disabled>
                            Kirim Progres Awal
                        </button>
                    </div>

                @elseif($hasBefore && !$hasAfter)
                    <!-- Tahap 2: Pekerjaan Selesai -->
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl text-center mb-6">
                        <span class="text-blue-700 font-bold text-sm">Pekerjaan Sedang Berjalan. <br>Silakan unggah foto hasil akhir jika pekerjaan sudah selesai!</span>
                    </div>

                    <button type="button" id="btnSelesai" class="w-full bg-emerald-600 text-white font-bold rounded-xl py-4 shadow-lg hover:bg-emerald-700 transition-colors">
                        Pekerjaan Selesai
                    </button>

                    <div id="afterSection" class="hidden space-y-4 mt-6">
                        <h3 class="font-bold text-slate-800 text-emerald-700">Foto Hasil Akhir (After)</h3>
                        <p class="text-sm text-slate-500 mb-2">Pilih atau ambil hingga 4 foto hasil pekerjaan selesai.</p>
                        <div class="grid grid-cols-2 gap-4">
                            @for($i=1; $i<=4; $i++)
                                <div class="relative group">
                                    <input type="file" name="foto_after[]" id="after_{{$i}}" accept="image/*" capture="environment" class="hidden file-input" data-type="after" data-index="{{$i}}">
                                    <button type="button" onclick="document.getElementById('after_{{$i}}').click()" class="w-full flex flex-col items-center justify-center p-4 border-2 border-dashed border-emerald-300 rounded-xl bg-emerald-50 hover:bg-emerald-100 h-32">
                                        <svg class="h-8 w-8 text-emerald-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                        <span class="text-xs font-bold text-emerald-600">Foto {{$i}}</span>
                                    </button>
                                    <img id="preview_after_{{$i}}" src="" class="hidden absolute inset-0 w-full h-full object-cover rounded-xl shadow-sm z-10">
                                    <button type="button" onclick="removeFoto('after', {{$i}})" id="remove_after_{{$i}}" class="hidden absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-full z-20 shadow">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @endfor
                        </div>

                        <button type="submit" id="submitAfter" class="w-full bg-slate-900 text-white font-bold rounded-xl py-4 mt-6 opacity-50 cursor-not-allowed" disabled>
                            Kirim Progres Akhir
                        </button>
                    </div>

                @else
                    <!-- Sudah Selesai -->
                    <div class="bg-emerald-50 border border-emerald-200 p-6 rounded-xl text-center">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-emerald-800 font-bold text-lg mb-1">Laporan Selesai</h3>
                        <p class="text-emerald-600 text-sm">Progres hari ini telah dikirim dan menunggu validasi admin.</p>
                    </div>
                @endif
                
            @else
                <div class="bg-slate-100 p-4 rounded-xl text-center text-sm text-slate-500 mt-4">
                    Silakan pilih proyek terlebih dahulu untuk memulai pengisian laporan progres.
                </div>
            @endif

            @error('foto')<p class="text-red-500 text-sm text-center font-bold">{{ $message }}</p>@enderror

        </form>
    </main>

    <script>
        document.getElementById('pekerjaanSelect').addEventListener('change', function() {
            if (this.value) {
                window.location.href = "{{ route('tim.input') }}?pekerjaan_id=" + this.value;
            } else {
                window.location.href = "{{ route('tim.input') }}";
            }
        });

        // Show Loading Overlay on Submit
        const form = document.getElementById('fotoForm');
        if (form) {
            form.addEventListener('submit', function() {
                document.getElementById('loadingOverlay').classList.remove('hidden');
                
                // Disable submit buttons to prevent double click
                const submitBefore = document.getElementById('submitBefore');
                if (submitBefore) submitBefore.disabled = true;
                const submitAfter = document.getElementById('submitAfter');
                if (submitAfter) submitAfter.disabled = true;
            });
        }

        // Image Compression Logic
        async function compressImage(file, maxWidth = 1200) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;

                        if (width > height) {
                            if (width > maxWidth) {
                                height = Math.round((height * maxWidth) / width);
                                width = maxWidth;
                            }
                        } else {
                            if (height > maxWidth) {
                                width = Math.round((width * maxWidth) / height);
                                height = maxWidth;
                            }
                        }

                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        canvas.toBlob((blob) => {
                            const newFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            resolve(newFile);
                        }, 'image/jpeg', 0.8);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        const fileInputs = document.querySelectorAll('.file-input');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', async function(e) {
                if(this.files && this.files[0]) {
                    const file = this.files[0];
                    const type = this.dataset.type;
                    const index = this.dataset.index;
                    
                    // Show a tiny loading state on the button
                    const btn = document.querySelector(`button[onclick="document.getElementById('${type}_${index}').click()"] span`);
                    const originalText = btn.innerText;
                    btn.innerText = "Memproses...";

                    // Compress Image
                    const compressedFile = await compressImage(file, 1200);
                    
                    // Replace file input value with compressed file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(compressedFile);
                    this.files = dataTransfer.files;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.getElementById(`preview_${type}_${index}`);
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                        document.getElementById(`remove_${type}_${index}`).classList.remove('hidden');
                        getLocation();
                        btn.innerText = originalText;
                    }
                    reader.readAsDataURL(compressedFile);
                }
            });
        });

        window.removeFoto = function(type, index) {
            const input = document.getElementById(`${type}_${index}`);
            input.value = '';
            document.getElementById(`preview_${type}_${index}`).classList.add('hidden');
            document.getElementById(`remove_${type}_${index}`).classList.add('hidden');
            checkSubmitStatus();
        }

        const latInput = document.getElementById('gps_latitude');
        const lngInput = document.getElementById('gps_longitude');
        const gpsStatus = document.getElementById('gpsStatus');

        function checkSubmitStatus() {
            const lat = latInput ? latInput.value : '';
            let hasBefore = false;
            let hasAfter = false;

            document.querySelectorAll('input[data-type="before"]').forEach(input => {
                if (input.files.length > 0) hasBefore = true;
            });
            document.querySelectorAll('input[data-type="after"]').forEach(input => {
                if (input.files.length > 0) hasAfter = true;
            });

            const submitBefore = document.getElementById('submitBefore');
            if (submitBefore) {
                if (hasBefore && lat) {
                    submitBefore.disabled = false;
                    submitBefore.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    submitBefore.disabled = true;
                    submitBefore.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            const submitAfter = document.getElementById('submitAfter');
            if (submitAfter) {
                if (hasAfter && lat) {
                    submitAfter.disabled = false;
                    submitAfter.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    submitAfter.disabled = true;
                    submitAfter.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        function getLocation() {
            if (!gpsStatus) return;
            
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
            if (!latInput || !lngInput) return;
            
            latInput.value = position.coords.latitude;
            lngInput.value = position.coords.longitude;
            
            if (gpsStatus) {
                gpsStatus.innerHTML = `
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lokasi GPS Terverifikasi: ${position.coords.latitude.toFixed(4)}, ${position.coords.longitude.toFixed(4)}
                    </span>
                `;
                gpsStatus.className = 'bg-green-50 text-green-700 p-3 rounded-lg text-xs font-semibold text-center border border-green-200 mt-0';
            }
            checkSubmitStatus();
        }

        function showError(error) {
            if (!gpsStatus) return;
            
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
            gpsStatus.className = 'bg-red-50 text-red-600 p-3 rounded-lg text-xs font-semibold text-center border border-red-200 mt-0';
            checkSubmitStatus();
        }

        const btnMulai = document.getElementById('btnMulai');
        if (btnMulai) {
            btnMulai.addEventListener('click', () => {
                document.getElementById('beforeSection').classList.remove('hidden');
                btnMulai.classList.add('hidden');
            });
        }

        const btnSelesai = document.getElementById('btnSelesai');
        if (btnSelesai) {
            btnSelesai.addEventListener('click', () => {
                document.getElementById('afterSection').classList.remove('hidden');
                btnSelesai.classList.add('hidden');
            });
        }
    </script>
</body>
</html>
