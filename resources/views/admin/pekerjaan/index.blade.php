@extends('layouts.admin')
@section('title', 'Manajemen Proyek')
@section('subtitle', 'Kelola daftar pekerjaan dan proyek yang sedang berjalan.')

@section('content')
<div class="glass-panel p-8 rounded-[2rem] shadow-sm border border-slate-200">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Proyek / Pekerjaan</h3>
            <p class="text-sm text-slate-500">Total: {{ $pekerjaans->count() }} Proyek</p>
        </div>
        <button onclick="document.getElementById('modalAdd').classList.remove('hidden')" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Proyek
        </button>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-y border-slate-200">
                <tr>
                        <th class="px-6 py-4 text-left font-bold text-slate-800">Nama Proyek</th>
                        <th class="px-6 py-4 text-left font-bold text-slate-800">Client</th>
                        <th class="px-6 py-4 text-left font-bold text-slate-800">Lokasi</th>
                        <th class="px-6 py-4 text-left font-bold text-slate-800">Tim Lapangan</th>
                        <th class="px-6 py-4 text-left font-bold text-slate-800">Tanggal</th>
                        <th class="px-6 py-4 text-left font-bold text-slate-800">Status</th>
                        <th class="px-6 py-4 text-right font-bold text-slate-800">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pekerjaans as $p)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4 font-medium text-slate-900">{{ $p->nama_pekerjaan }}</td>
                    <td class="px-6 py-4 text-slate-600 font-medium">{{ $p->client->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $p->lokasi->nama_lokasi ?? '-' }}</td>
                    <td class="px-6 py-4 text-slate-600">
                        @if($p->user)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $p->user->name }}
                            </span>
                        @else
                            <span class="text-xs text-slate-400 italic">Belum di-assign</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        @if($p->status == 'Aktif')
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">AKTIF</span>
                        @elseif($p->status == 'Selesai')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">SELESAI</span>
                        @else
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">PENDING</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button onclick="editProyek({{ $p->id }}, '{{ $p->nama_pekerjaan }}', '{{ $p->client->nama ?? '' }}', '{{ $p->lokasi->nama_lokasi ?? '' }}', '{{ $p->tanggal }}', '{{ $p->status }}', '{{ $p->user_id }}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <form action="{{ route('admin.pekerjaan.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus proyek ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada proyek ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Add -->
<div id="modalAdd" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Tambah Proyek</h3>
            <button onclick="document.getElementById('modalAdd').classList.add('hidden')" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form action="{{ route('admin.pekerjaan.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Pekerjaan</label>
                <input type="text" name="nama_pekerjaan" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Client (Ketik nama client baru atau pilih)</label>
                <input type="text" name="client_nama" list="clientList" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none" placeholder="Contoh: PT. Adhi Karya" required>
                <datalist id="clientList">
                    @foreach($clients as $c) <option value="{{ $c->nama }}"> @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Lokasi (Ketik lokasi baru atau pilih yang ada)</label>
                <input type="text" name="lokasi_nama" list="lokasiList" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none" placeholder="Contoh: Mall Metropolitan, Bekasi" required>
                <datalist id="lokasiList">
                    @foreach($lokasis as $l) <option value="{{ $l->nama_lokasi }}"> @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Assign ke Tim Lapangan</label>
                <select name="user_id" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none">
                    <option value="">-- Belum Di-assign --</option>
                    @foreach($timLapangans as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-brand-600 text-white font-bold py-3 rounded-xl hover:bg-brand-700">Simpan Proyek</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Edit Proyek</h3>
            <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="formEdit" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Pekerjaan</label>
                <input type="text" name="nama_pekerjaan" id="edit_nama" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Client (Ketik nama client baru atau pilih)</label>
                <input type="text" name="client_nama" id="edit_client" list="clientListEdit" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none" placeholder="Contoh: PT. Adhi Karya" required>
                <datalist id="clientListEdit">
                    @foreach($clients as $c) <option value="{{ $c->nama }}"> @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Lokasi (Ketik lokasi baru atau pilih yang ada)</label>
                <input type="text" name="lokasi_nama" id="edit_lokasi" list="lokasiListEdit" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none" placeholder="Contoh: Mall Metropolitan, Bekasi" required>
                <datalist id="lokasiListEdit">
                    @foreach($lokasis as $l) <option value="{{ $l->nama_lokasi }}"> @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal" id="edit_tanggal" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Assign ke Tim Lapangan</label>
                <select name="user_id" id="edit_user" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none">
                    <option value="">-- Belum Di-assign --</option>
                    @foreach($timLapangans as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Status Proyek</label>
                <select name="status" id="edit_status" class="w-full border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-500 outline-none" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-brand-600 text-white font-bold py-3 rounded-xl hover:bg-brand-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function editProyek(id, nama, clientNama, lokasiNama, tanggal, status, userId) {
        document.getElementById('modalEdit').classList.remove('hidden');
        document.getElementById('formEdit').action = '/admin/pekerjaan/' + id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_client').value = clientNama;
        document.getElementById('edit_lokasi').value = lokasiNama;
        
        // ensure date format is YYYY-MM-DD
        let formattedDate = tanggal;
        if(tanggal.includes(' ')) {
            formattedDate = tanggal.split(' ')[0];
        }
        document.getElementById('edit_tanggal').value = formattedDate;
        
        if (status) {
            document.getElementById('edit_status').value = status;
        }
        if (userId) {
            document.getElementById('edit_user').value = userId;
        } else {
            document.getElementById('edit_user').value = "";
        }
    }
</script>
@endpush
