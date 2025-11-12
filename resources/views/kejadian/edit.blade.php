@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Kejadian Bencana</h3>

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

    {{-- ✅ Tambahkan enctype agar bisa upload file --}}
    <form method="POST" action="{{ route('kejadian-bencana.update', $kejadian->kejadian_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ✅ Tampilkan foto lama (jika ada) --}}
        @if (!empty($kejadian->foto))
            <div class="mb-3">
                <label class="form-label">Foto Sebelumnya</label><br>
                <img src="{{ asset('storage/' . $kejadian->foto) }}"
                     alt="Foto Sebelumnya"
                     class="img-thumbnail mb-2"
                     width="200">
            </div>
        @endif

        {{-- ✅ Form input lainnya --}}
        @include('kejadian.form', ['kejadian' => $kejadian])

        <div class="mb-3">
            <label class="form-label">Ganti Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kejadian-bencana.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
