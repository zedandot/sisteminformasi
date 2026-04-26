@extends('layouts.admin')

@section('title', 'Lokasi Tim Lapangan')
@section('subtitle', 'Pantau posisi dan lokasi tim lapangan secara real-time.')

@section('content')
<div class="flex items-center justify-center h-64">
    <div class="text-center">
        <div class="w-20 h-20 bg-brand-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-700 mb-2">Lokasi Tim Lapangan</h3>
        <p class="text-slate-400 text-sm">Fitur peta lokasi tim sedang dalam pengembangan.</p>
    </div>
</div>
@endsection
