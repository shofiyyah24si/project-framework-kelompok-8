@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Warga</h1>
<p class="text-xs text-slate-400 mb-6">Perbarui data warga bila ada perubahan.</p>

<form action="{{ route('warga.update', $data->warga_id) }}" method="POST"
      class="rounded-2xl bg-navySoft/80 border border-slate-700/70 p-6 max-w-3xl">
    @csrf
    @method('PUT')

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $data->nama) }}"
                   class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 focus:ring-accent">
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">NIK</label>
            <input type="text" name="nik" value="{{ old('nik', $data->nik) }}"
                   class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 focus:ring-accent">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-medium text-slate-300 mb-1">Alamat</label>
            <textarea name="alamat" rows="3"
                      class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 focus:ring-accent">{{ old('alamat', $data->alamat) }}</textarea>
        </div>

        <div class="md:col-span-2 md:max-w-xs">
            <label class="block text-xs font-medium text-slate-300 mb-1">No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $data->no_hp) }}"
                   class="w-full rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 focus:ring-accent">
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('warga.index') }}"
           class="px-4 py-2 text-sm rounded-xl border border-slate-600 text-slate-300 hover:bg-slate-800/70">
            Batal
        </a>
        <button type="submit"
                class="px-4 py-2 text-sm rounded-xl bg-accent hover:bg-accentSoft text-white font-medium shadow-lg shadow-blue-500/30">
            Update
        </button>
    </div>
</form>
@endsection


{{-- ================= FIX MUTER-MUTER BACK BUTTON ================= --}}
<script>
// Jika halaman edit disimpan Chrome (BFCache), langsung lempar ke index
window.addEventListener("pageshow", function (e) {
    if (e.persisted) {
        window.location.replace("{{ route('warga.index') }}");
    }
});

// Hapus halaman EDIT dari riwayat — tombol Back tidak kembali ke sini
history.replaceState(null, "", "{{ route('warga.index') }}");
</script>
