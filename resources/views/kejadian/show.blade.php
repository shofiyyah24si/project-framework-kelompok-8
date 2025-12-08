@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-semibold mb-1">Detail Kejadian Bencana</h1>
<p class="text-xs text-slate-400 mb-6">
    Informasi lengkap bencana, dokumentasi, dan status penanganan.
</p>

<div class="bg-navySoft border border-slate-700 rounded-2xl p-8 shadow-xl">

    {{-- INFORMASI UTAMA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- FOTO UTAMA --}}
        <div>
            <h2 class="text-lg font-semibold mb-3">Foto Utama</h2>

            @if($data->foto)
                <img src="{{ asset('storage/'.$data->foto) }}"
                     class="rounded-xl border border-slate-700 shadow-lg w-full object-cover max-h-80">
            @else
                <p class="text-slate-400 text-sm italic">Tidak ada foto utama.</p>
            @endif
        </div>

        {{-- DETAIL INFO --}}
        <div>
            <h2 class="text-lg font-semibold mb-3">Informasi Kejadian</h2>

            <div class="space-y-2 text-sm">

                <p><span class="font-semibold">Jenis Bencana:</span> {{ $data->jenis_bencana }}</p>
                <p><span class="font-semibold">Tanggal:</span> {{ $data->tanggal }}</p>
                <p><span class="font-semibold">Lokasi:</span> {{ $data->lokasi_text }}</p>
                <p><span class="font-semibold">RT/RW:</span> {{ $data->rt }}/{{ $data->rw }}</p>
                <p><span class="font-semibold">Dampak:</span> {{ $data->dampak }}</p>
                <p><span class="font-semibold">Status:</span> {{ $data->status_kejadian }}</p>
                <p><span class="font-semibold">Keterangan:</span> {{ $data->keterangan ?? '-' }}</p>

            </div>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('kejadian.edit', $data->kejadian_id) }}"
                   class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-500 transition">
                   Edit
                </a>

                <form action="{{ route('kejadian.destroy', $data->kejadian_id) }}" method="POST"
                      onsubmit="return confirm('Hapus kejadian ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 rounded-xl bg-red-600 text-white hover:bg-red-500 transition">
                        Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>


    {{-- DOKUMENTASI --}}
    <div class="mt-12">
        <h2 class="text-lg font-semibold mb-4">Dokumentasi Tambahan</h2>

        @if($data->files->count() == 0)
            <p class="text-slate-400 text-sm">Tidak ada dokumentasi tambahan.</p>
        @else

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                @foreach($data->files as $file)

                    <div class="bg-slate-800/40 border border-slate-700 rounded-xl p-3">

                        {{-- File IMAGE --}}
                        @if(in_array($file->tipe, ['jpg','jpeg','png']))
                            <img src="{{ $file->url }}" class="rounded-lg h-40 w-full object-cover">
                        @endif

                        {{-- File VIDEO --}}
                        @if(in_array($file->tipe, ['mp4','mov','avi','mkv']))
                            <video controls class="rounded-lg w-full h-40">
                                <source src="{{ $file->url }}" type="video/{{ $file->tipe }}">
                            </video>
                        @endif

                        {{-- File PDF --}}
                        @if($file->tipe == 'pdf')
                            <div class="flex items-center justify-center h-40">
                                <i class="fa-solid fa-file-pdf text-red-400 text-5xl"></i>
                            </div>

                            <a href="{{ $file->url }}" target="_blank"
                               class="block mt-2 text-blue-400 hover:text-blue-300 text-xs text-center">
                                Buka PDF
                            </a>
                        @endif

                        {{-- File lainnya --}}
                        @if(!in_array($file->tipe, ['jpg','jpeg','png','mp4','mov','avi','mkv','pdf']))
                            <p class="text-xs text-slate-400 mt-2">
                                File: {{ $file->nama_file }}
                            </p>

                            <a href="{{ $file->url }}" target="_blank"
                               class="text-blue-400 text-xs hover:text-blue-300">
                                Download
                            </a>
                        @endif

                    </div>

                @endforeach

            </div>

        @endif
    </div>

</div>

@endsection
