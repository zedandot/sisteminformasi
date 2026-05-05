@extends('layouts.admin')

@section('title', 'Peta Lokasi Tim Lapangan')
@section('subtitle', 'Pantau titik lokasi pengambilan foto tim lapangan secara visual melalui integrasi GPS.')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        height: 600px;
        width: 100%;
        border-radius: 2rem;
        z-index: 1;
    }
</style>
@endpush

@section('content')

<div class="bg-white rounded-[2.5rem] p-4 md:p-8 border border-slate-100 shadow-sm">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Live Mapping</h3>
            <p class="text-sm text-slate-500">Menampilkan 20 koordinat foto terakhir.</p>
        </div>
        <div class="flex items-center gap-4 text-sm font-medium">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span> Titik GPS
            </div>
            <button onclick="map.setView([-6.200000, 106.816666], 10)" class="text-blue-600 hover:text-blue-700 hover:underline">Reset Pandangan</button>
        </div>
    </div>

    <!-- Map Container -->
    <div class="relative overflow-hidden shadow-inner border border-slate-200 rounded-[2rem]">
        <div id="map"></div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Inisialisasi peta ke koordinat tengah (misal Jakarta)
    var map = L.map('map').setView([-6.200000, 106.816666], 10);

    // Tambahkan layer tile dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Data marker dari controller
    var markersData = @json($markers);

    // Tambahkan marker ke peta
    var bounds = [];
    markersData.forEach(function(marker) {
        var markerObj = L.marker([marker.lat, marker.lng]).addTo(map)
            .bindPopup(marker.popup);
        bounds.push([marker.lat, marker.lng]);
    });

    // Sesuaikan pandangan peta agar semua marker terlihat
    if (bounds.length > 0) {
        map.fitBounds(bounds);
    }
</script>
@endpush
