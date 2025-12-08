@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <h1 class="text-2xl font-semibold mb-6">Edit Kejadian Bencana</h1>

    <div class="rounded-2xl bg-navySoft/70 border border-slate-700 p-8 shadow-xl">

        <form action="{{ route('kejadian.update', $data->kejadian_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- GRID FORM --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <div>
                    <label class="text-sm text-slate-300">Jenis Bencana</label>
                    <input type="text" name="jenis_bencana" value="{{ $data->jenis_bencana }}" class="input-dark">
                </div>

                <div>
                    <label class="text-sm text-slate-300">Status Kejadian</label>
                    <select name="status_kejadian" class="input-dark">
                        <option value="Baru" {{ $data->status_kejadian=='Baru'?'selected':'' }}>Baru</option>
                        <option value="Proses" {{ $data->status_kejadian=='Proses'?'selected':'' }}>Proses</option>
                        <option value="Selesai" {{ $data->status_kejadian=='Selesai'?'selected':'' }}>Selesai</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-slate-300">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $data->tanggal }}" class="input-dark">
                </div>

                <div>
                    <label class="text-sm text-slate-300">Lokasi</label>
                    <input type="text" name="lokasi_text" value="{{ $data->lokasi_text }}" class="input-dark">
                </div>

                <div>
                    <label class="text-sm text-slate-300">RT</label>
                    <input type="text" name="rt" value="{{ $data->rt }}" class="input-dark">
                </div>

                <div>
                    <label class="text-sm text-slate-300">RW</label>
                    <input type="text" name="rw" value="{{ $data->rw }}" class="input-dark">
                </div>
            </div>

            {{-- Dampak --}}
            <div class="mt-5">
                <label class="text-sm text-slate-300">Dampak</label>
                <input type="text" name="dampak" value="{{ $data->dampak }}" class="input-dark">
            </div>

            {{-- Keterangan --}}
            <div class="mt-5">
                <label class="text-sm text-slate-300">Keterangan</label>
                <textarea name="keterangan" rows="3" class="input-dark">{{ $data->keterangan }}</textarea>
            </div>

            {{-- FOTO UTAMA --}}
            <div class="mt-6">
                <label class="text-sm text-slate-300">Foto Utama</label>

                @if($data->foto)
                    <img src="{{ asset('storage/'.$data->foto) }}"
                         class="w-full max-w-xs h-32 object-cover rounded-xl border border-slate-700 mt-2">
                @endif

                <input type="file" name="foto" class="file-dark mt-3">
            </div>

            {{-- DOKUMENTASI --}}
            <div class="mt-8">
                <label class="text-sm font-semibold text-slate-300">Dokumentasi Kejadian</label>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">

                    @foreach($data->files as $file)
                        <div class="bg-slate-800/60 border border-slate-700 rounded-xl p-2">

                            {{-- IMAGE --}}
                            @if($file->is_image)
                                <img src="{{ $file->url }}" class="h-28 w-full object-cover rounded-lg">
                            @endif

                            {{-- PDF --}}
                            @if($file->is_document)
                                <div class="h-28 flex items-center justify-center text-slate-300">
                                    <i class="fa fa-file-pdf text-3xl text-red-400"></i>
                                </div>
                            @endif

                            {{-- VIDEO --}}
                            @if($file->is_video)
                                <video class="h-28 w-full rounded-lg" controls>
                                    <source src="{{ $file->url }}">
                                </video>
                            @endif

                            <form action="{{ route('kejadian.deleteFile', $file->id) }}" method="POST" class="mt-2 text-right">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-400 hover:text-red-300 text-xs">Hapus</button>
                            </form>

                        </div>
                    @endforeach
                </div>

                {{-- TAMBAH BARU --}}
                <div class="mt-4">
                    <label class="text-sm text-slate-300">Tambah Dokumentasi Baru</label>
                    <input type="file" name="files[]" multiple class="file-dark mt-2">
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('kejadian.index') }}" class="btn-secondary">Batal</a>
                <button class="btn-primary">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>

@endsection
