@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Tambah Kejadian Bencana</h3>

    {{-- Tampilkan error validasi jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ Form Tambah Kejadian --}}
    {{-- Tambahkan enctype="multipart/form-data" agar bisa upload file --}}
    <form method="POST" action="{{ route('kejadian-bencana.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Partial form berisi input --}}
        @include('kejadian.form')

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kejadian-bencana.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
