@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Posko Bencana</h1>
<p class="text-xs text-slate-400 mb-6">Perbarui informasi posko jika terdapat perubahan.</p>

<form action="{{ route('posko.update', $data) }}" method="POST" enctype="multipart/form-data"
      class="rounded-2xl bg-navySoft/80 border border-slate-700 p-6 max-w-3xl">
    @csrf
    @method('PUT')

    <div class="grid md:grid-cols-2 gap-4">
        
        <div class="md:col-span-2">
            <label class="block text-xs font-medium text-slate-300 mb-1">Kejadian Terkait</label>
            <select name="kejadian_id"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 text-sm text-slate-100">
                @foreach($kejadian as $k)
                    <option value="{{ $k->kejadian_id }}"
                        {{ $data->kejadian_id == $k->kejadian_id ? 'selected' : '' }}>
                        {{ $k->jenis_bencana }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs text-slate-300 mb-1">Nama Posko</label>
            <input type="text" name="nama" value="{{ old('nama', $data->nama) }}"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 text-sm text-slate-100">
        </div>

        <div>
            <label class="block text-xs text-slate-300 mb-1">Kontak</label>
            <input type="text" name="kontak" value="{{ old('kontak', $data->kontak) }}"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 text-sm text-slate-100">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs text-slate-300 mb-1">Alamat</label>
            <textarea name="alamat" rows="3"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 text-sm text-slate-100">{{ old('alamat', $data->alamat) }}</textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs text-slate-300 mb-1">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab', $data->penanggung_jawab) }}"
                class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 text-sm text-slate-100">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-medium text-slate-300 mb-1">Foto Posko</label>
            <input type="file" name="foto"
                class="w-full text-sm text-slate-200 file:mr-3 file:rounded-lg 
                       file:border-none file:bg-accent file:px-3 file:py-1.5 file:text-xs 
                       file:font-medium file:text-white hover:file:bg-accentSoft">

            @if($data->foto)
                <img src="{{ asset('storage/'.$data->foto) }}"
                     class="mt-3 w-40 h-28 object-cover rounded-xl border border-slate-700">
            @endif
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
            Update
        </button>
    </div>
</form>
@endsection
