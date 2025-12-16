@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold mb-1">Data Kejadian Bencana</h1>
        <p class="text-xs text-slate-400">Pendataan kejadian bencana, lokasi, dan dampaknya.</p>
    </div>

    <a href="{{ route('kejadian.create') }}"
       class="inline-flex items-center gap-2 rounded-xl bg-accent hover:bg-accentSoft
              px-4 py-2 text-sm font-medium text-white shadow-md shadow-blue-500/30 transition">
        <span class="text-lg">＋</span> Tambah Kejadian
    </a>
</div>


{{-- SEARCH + FILTER --}}
<form method="GET" class="flex flex-wrap gap-3 mb-6">

    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Cari bencana / lokasi / status..."
           class="px-4 py-2 rounded-xl bg-slate-800 border border-slate-700 w-60 text-sm">

    <select name="status"
            class="px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-sm">
        <option value="">Filter Status</option>
        <option value="Baru" {{ request('status')=='Baru' ? 'selected' : '' }}>Baru</option>
        <option value="Berlangsung" {{ request('status')=='Berlangsung' ? 'selected' : '' }}>Berlangsung</option>
        <option value="Selesai" {{ request('status')=='Selesai' ? 'selected' : '' }}>Selesai</option>
    </select>

    <input type="date"
           name="tanggal"
           value="{{ request('tanggal') }}"
           class="px-4 py-2 rounded-xl bg-slate-800 border border-slate-700 text-sm">

    <button class="px-4 py-2 bg-accent text-white rounded-xl">Terapkan</button>
</form>



@if ($data->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-700 bg-navySoft/60 p-6 text-center text-sm text-slate-400">
        Tidak ada data kejadian ditemukan.
    </div>

@else

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($data as $k)
            <div class="rounded-2xl bg-navySoft/80 border border-slate-700 p-5 shadow-lg shadow-black/30">

                {{-- FOTO UTAMA --}}
                @if($k->foto)
                    <img src="{{ asset('storage/' . $k->foto) }}"
                         class="w-full h-40 object-cover rounded-xl mb-4 border border-slate-700">
                @endif

                {{-- JUDUL --}}
                <h3 class="text-lg font-semibold mb-2">{{ $k->jenis_bencana }}</h3>

                {{-- INFO --}}
                <div class="space-y-1 text-sm text-slate-300">
                    <p><b class="text-slate-200">Tanggal:</b> {{ $k->tanggal }}</p>
                    <p><b class="text-slate-200">Lokasi:</b> {{ $k->lokasi_text }}</p>
                    <p><b class="text-slate-200">RT/RW:</b> {{ $k->rt }}/{{ $k->rw }}</p>
                    <p><b class="text-slate-200">Dampak:</b> {{ $k->dampak }}</p>
                    <p><b class="text-slate-200">Status:</b> {{ $k->status_kejadian }}</p>

                    @if ($k->keterangan)
                        <p><b class="text-slate-200">Keterangan:</b> {{ $k->keterangan }}</p>
                    @endif
                </div>

                {{-- TOMBOL DETAIL (SAJA) --}}
                <div class="mt-5 flex justify-center">
                    <a href="{{ route('kejadian.show', $k->kejadian_id) }}"
                       class="px-4 py-2 text-sm rounded-xl bg-accent hover:bg-accentSoft text-white shadow-md">
                        Detail
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-10 flex justify-center">
        {{ $data->appends(request()->query())->links('vendor.pagination.blue') }}
    </div>

@endif

@endsection
