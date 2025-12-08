@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Tambah Posko Bencana</h1>
<p class="text-xs text-slate-400 mb-6">
    Lengkapi data posko dengan benar agar koordinasi penanggulangan berjalan optimal.
</p>

<form action="{{ route('posko.store') }}" method="POST" enctype="multipart/form-data"
      class="rounded-2xl bg-navySoft/80 border border-slate-700 p-6 max-w-3xl">
    @csrf

    <div class="grid md:grid-cols-2 gap-4">
        
        <div class="md:col-span-2">
            <label class="block text-xs font-medium text-slate-300 mb-1">Kejadian Terkait</label>
            <select name="kejadian_id"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 
                       text-sm text-slate-100 focus:ring-1 focus:ring-accent">
                <option value="">-- Pilih Kejadian --</option>
                @foreach($kejadian as $k)
                    <option value="{{ $k->kejadian_id }}">{{ $k->jenis_bencana }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs text-slate-300 mb-1">Nama Posko</label>
            <input type="text" name="nama"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 
                       text-sm text-slate-100 focus:ring-1 focus:ring-accent">
        </div>

        <div>
            <label class="block text-xs text-slate-300 mb-1">Kontak</label>
            <input type="text" name="kontak"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 
                       text-sm text-slate-100 focus:ring-1 focus:ring-accent">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs text-slate-300 mb-1">Alamat</label>
            <textarea name="alamat" rows="3"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 
                       text-sm text-slate-100 focus:ring-1 focus:ring-accent"></textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs text-slate-300 mb-1">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 
                       text-sm text-slate-100 focus:ring-1 focus:ring-accent">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-medium text-slate-300 mb-1">Foto Posko</label>
            <input type="file" name="foto"
                class="w-full text-sm text-slate-200 file:mr-3 file:rounded-lg file:border-none
                       file:bg-accent file:px-3 file:py-1.5 file:text-xs 
                       file:font-medium file:text-white hover:file:bg-accentSoft">
        </div>

    </div>

    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('posko.index') }}"
           class="px-4 py-2 text-sm rounded-xl border border-slate-600 text-slate-300 hover:bg-slate-800/70">
            Batal
        </a>
        <button type="submit"
            class="px-4 py-2 text-sm rounded-xl bg-accent hover:bg-accentSoft text-white 
                   font-medium shadow-lg shadow-blue-500/30">
            Simpan
        </button>
    </div>
</form>
@endsection
