@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-4">Tambah Kejadian Bencana</h1>
<p class="text-xs text-slate-400 mb-6">
    Catat informasi kejadian bencana dengan detail untuk memudahkan penanganan.
</p>

<div class="bg-navySoft border border-slate-700 rounded-2xl p-8 shadow-xl">

<form action="{{ route('kejadian.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- JENIS BENCANA --}}
        <div>
            <label class="text-sm font-medium text-slate-200">Jenis Bencana</label>
            <input type="text" name="jenis_bencana"
                class="mt-1 w-full rounded-xl bg-slate-900/50 border border-slate-700 px-4 py-2 text-sm text-slate-100 
                       focus:ring-2 focus:ring-accent focus:outline-none placeholder-slate-500">
        </div>

        {{-- TANGGAL --}}
        <div>
            <label class="text-sm font-medium text-slate-200">Tanggal</label>
            <input type="date" name="tanggal"
                class="mt-1 w-full rounded-xl bg-slate-900/50 border border-slate-700 px-4 py-2 text-sm text-slate-100 
                       focus:ring-2 focus:ring-accent focus:outline-none">
        </div>

        {{-- LOKASI --}}
        <div class="md:col-span-2">
            <label class="text-sm font-medium text-slate-200">Lokasi</label>
            <input type="text" name="lokasi_text"
                class="mt-1 w-full rounded-xl bg-slate-900/50 border border-slate-700 px-4 py-2 text-sm text-slate-100 
                       focus:ring-2 focus:ring-accent focus:outline-none">
        </div>

        {{-- RT --}}
        <div>
            <label class="text-sm font-medium text-slate-200">RT</label>
            <input type="text" name="rt"
                class="mt-1 w-full rounded-xl bg-slate-900/50 border border-slate-700 px-4 py-2 text-sm text-slate-100 
                       focus:ring-2 focus:ring-accent focus:outline-none">
        </div>

        {{-- RW --}}
        <div>
            <label class="text-sm font-medium text-slate-200">RW</label>
            <input type="text" name="rw"
                class="mt-1 w-full rounded-xl bg-slate-900/50 border border-slate-700 px-4 py-2 text-sm text-slate-100 
                       focus:ring-2 focus:ring-accent focus:outline-none">
        </div>

        {{-- DAMPAK --}}
        <div class="md:col-span-2">
            <label class="text-sm font-medium text-slate-200">Dampak</label>
            <textarea name="dampak" rows="2"
                class="mt-1 w-full rounded-xl bg-slate-900/50 border border-slate-700 px-4 py-2 text-sm text-slate-100 
                       focus:ring-2 focus:ring-accent focus:outline-none"></textarea>
        </div>

        {{-- STATUS --}}
        <div>
            <label class="text-sm font-medium text-slate-200">Status Kejadian</label>
            <select name="status_kejadian"
                class="mt-1 w-full rounded-xl bg-slate-900/50 border border-slate-700 px-4 py-2 text-sm text-slate-100 
                       focus:ring-2 focus:ring-accent focus:outline-none">
                <option value="">-- Pilih Status --</option>
                <option value="Baru">Baru</option>
                <option value="Proses">Proses</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>

        {{-- FOTO UTAMA --}}
        <div class="md:col-span-2">
            <label class="text-sm font-medium text-slate-200">Foto Utama Kejadian</label>
            <input type="file" name="foto"
                class="mt-2 block w-full text-sm text-slate-200
                       file:mr-4 file:rounded-lg file:border-0 file:bg-accent file:px-4 file:py-2 file:text-xs file:font-medium 
                       hover:file:bg-accentSoft cursor-pointer">
        </div>

        {{-- MULTIPLE FILE --}}
        <div class="md:col-span-2">
            <label class="text-sm font-medium text-slate-200">Dokumentasi Tambahan (Multiple Upload)</label>
            <input type="file" name="files[]" multiple
                class="mt-2 block w-full text-sm text-slate-200
                       file:mr-4 file:rounded-lg file:border-0 file:bg-accent file:px-4 file:py-2 file:text-xs file:font-medium 
                       hover:file:bg-accentSoft cursor-pointer">

            <p class="text-xs text-slate-400 mt-2">
                *Dapat mengunggah banyak file sekaligus (foto/video/pdf)
            </p>
        </div>

        {{-- KETERANGAN --}}
        <div class="md:col-span-2">
            <label class="text-sm font-medium text-slate-200">Keterangan</label>
            <textarea name="keterangan" rows="3"
                class="mt-1 w-full rounded-xl bg-slate-900/50 border border-slate-700 px-4 py-2 text-sm text-slate-100 
                       focus:ring-2 focus:ring-accent focus:outline-none"></textarea>
        </div>

    </div>

    <div class="mt-8 flex justify-end gap-4">
        <a href="{{ route('kejadian.index') }}"
            class="px-4 py-2 rounded-xl border border-slate-600 text-slate-300 hover:bg-slate-800/60 transition">
            Batal
        </a>

        <button class="px-4 py-2 rounded-xl bg-accent text-white font-medium hover:bg-accentSoft transition">
            Simpan
        </button>
    </div>

</form>

</div>

@endsection
