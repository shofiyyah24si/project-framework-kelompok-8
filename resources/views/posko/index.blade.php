@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold mb-1">Data Posko Bencana</h1>
        <p class="text-xs text-slate-400">Manajemen posko, penanggung jawab, dan informasi kontak darurat.</p>
    </div>

    <a href="{{ route('posko.create') }}"
       class="inline-flex items-center gap-2 rounded-xl bg-accent hover:bg-accentSoft
              px-4 py-2 text-sm font-medium text-white shadow-md shadow-blue-500/30 transition">
        <span class="text-lg">＋</span> Tambah Posko
    </a>
</div>


{{-- SEARCH + FILTER --}}
<form method="GET" class="flex flex-wrap gap-3 mb-6">

    {{-- SEARCH --}}
    <input type="text" name="search"
           value="{{ request('search') }}"
           placeholder="Cari nama posko / alamat / PJ..."
           class="px-4 py-2 rounded-xl bg-slate-800 border border-slate-700 w-60 text-sm">

    {{-- FILTER KEJADIAN --}}
    <select name="kejadian_id"
            class="px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-sm">
        <option value="">Filter Kejadian</option>
        @foreach ($listKejadian as $k)
            <option value="{{ $k->kejadian_id }}" {{ request('kejadian_id') == $k->kejadian_id ? 'selected' : '' }}>
                {{ $k->jenis_bencana }}
            </option>
        @endforeach
    </select>

    {{-- FILTER LOKASI --}}
    <input type="text" name="lokasi"
           value="{{ request('lokasi') }}"
           placeholder="Lokasi (Alamat)"
           class="px-4 py-2 rounded-xl bg-slate-800 border border-slate-700 w-40 text-sm">

    {{-- BUTTON --}}
    <button class="px-4 py-2 bg-accent text-white rounded-xl">
        Terapkan
    </button>
</form>



@if ($data->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-700 bg-navySoft/60 p-6 text-center text-sm text-slate-400">
        Tidak ada data posko ditemukan.
    </div>

@else

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        @foreach ($data as $p)
        <div class="rounded-2xl bg-navySoft/80 border border-slate-700/70 p-5 shadow-lg shadow-black/30">

            @if($p->foto)
                <img src="{{ asset('storage/'.$p->foto) }}"
                     class="w-full h-40 object-cover rounded-xl mb-4 border border-slate-700">
            @endif

            <h3 class="text-lg font-semibold mb-1">{{ $p->nama }}</h3>

            <div class="space-y-1 text-sm text-slate-300">
                <p><b class="text-slate-200">Kejadian:</b> {{ $p->kejadian->jenis_bencana ?? '-' }}</p>
                <p><b class="text-slate-200">Alamat:</b> {{ $p->alamat }}</p>
                <p><b class="text-slate-200">Kontak:</b> {{ $p->kontak }}</p>
                <p><b class="text-slate-200">PJ:</b> {{ $p->penanggung_jawab }}</p>
            </div>

            <div class="mt-4 flex items-center justify-between text-sm">
                <a href="{{ route('posko.edit', $p) }}"
                   class="text-accent hover:text-accentSoft font-medium">
                    Edit
                </a>

                <form action="{{ route('posko.destroy', $p) }}" method="POST"
                      onsubmit="return confirm('Hapus data posko ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-400 hover:text-red-300 font-medium">Hapus</button>
                </form>
            </div>

        </div>
        @endforeach

    </div>

    {{-- PAGINATION PROFESIONAL --}}
    <div class="mt-8 flex justify-center">
        {{ $data->appends(request()->query())->links('vendor.pagination.blue') }}
    </div>

@endif

@endsection
