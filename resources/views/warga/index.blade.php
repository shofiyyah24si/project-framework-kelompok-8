@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold mb-1">Data Warga</h1>
        <p class="text-xs text-slate-400">Kelola data warga desa untuk kebutuhan tanggap darurat.</p>
    </div>

    <a href="{{ route('warga.create') }}"
       class="inline-flex items-center gap-2 rounded-xl bg-accent hover:bg-accentSoft
              px-4 py-2 text-sm font-medium text-white shadow-md shadow-blue-500/30 transition">
        <span class="text-lg">＋</span> Tambah Warga
    </a>
</div>

{{-- Search and Filter --}}
<form method="GET" class="flex gap-3 items-center mb-6">
    <input type="text" name="search" value="{{ request('search') }}" class="rounded-xl border border-slate-700 bg-navySoft/50 px-4 py-2 text-sm text-white w-60 focus:outline-none" placeholder="Cari nama / NIK / alamat / no hp...">
    <select name="rt" class="rounded-xl border border-slate-700 bg-navySoft/50 px-4 py-2 text-sm text-white w-32">
        <option value="">Filter RT</option>
        @for ($i = 1; $i <= 20; $i++)
            <option value="{{ $i }}" {{ request('rt') == $i ? 'selected' : '' }}>RT {{ $i }}</option>
        @endfor
    </select>
    <select name="rw" class="rounded-xl border border-slate-700 bg-navySoft/50 px-4 py-2 text-sm text-white w-32">
        <option value="">Filter RW</option>
        @for ($i = 1; $i <= 20; $i++)
            <option value="{{ $i }}" {{ request('rw') == $i ? 'selected' : '' }}>RW {{ $i }}</option>
        @endfor
    </select>
    <button class="rounded-xl bg-accent hover:bg-accentSoft px-4 py-2 text-sm text-white font-medium">Terapkan</button>
</form>

{{-- List Data Warga --}}
@if ($data->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-700 bg-navySoft/60 p-6 text-center text-sm text-slate-400">
        Tidak ada data ditemukan.
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($data as $w)
            <div class="rounded-2xl bg-navySoft/80 border border-slate-700/70 p-5 shadow-lg shadow-black/30">
                <h3 class="text-lg font-semibold mb-2">{{ $w->nama }}</h3>
                <div class="space-y-1 text-sm text-slate-300">
                    <p><span class="font-semibold text-slate-200">NIK:</span> {{ $w->nik }}</p>
                    <p><span class="font-semibold text-slate-200">Alamat:</span> {{ $w->alamat }}</p>
                    <p><span class="font-semibold text-slate-200">RT/RW:</span> {{ $w->rt }}/{{ $w->rw }}</p>
                    <p><span class="font-semibold text-slate-200">No HP:</span> {{ $w->no_hp }}</p>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm">
                    <a href="{{ route('warga.edit', $w->warga_id) }}" class="text-accent hover:text-accentSoft font-medium">Edit</a>
                    <form action="{{ route('warga.destroy', $w->warga_id) }}" method="POST" onsubmit="return confirm('Hapus data warga ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-400 hover:text-red-300 font-medium">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Pagination --}}
<div class="mt-6">
    {{ $data->appends(request()->query())->links('vendor.pagination.blue') }}
</div>

@endsection
