@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between">
            <h5>Tambah Kejadian Bencana</h5>
            <a href="{{ route('kejadian.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <div class="card-body">
            <form action="{{ route('kejadian.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jenis Bencana</label>
                        <input type="text" name="jenis_bencana" value="{{ old('jenis_bencana') }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal Kejadian</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control">
                    </div>

                    <div class="col-md-8 mb-3">
                        <label>Lokasi</label>
                        <input type="text" name="lokasi_text" value="{{ old('lokasi_text') }}" class="form-control">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>RT</label>
                        <input type="text" name="rt" value="{{ old('rt') }}" class="form-control">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>RW</label>
                        <input type="text" name="rw" value="{{ old('rw') }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Dampak</label>
                        <input type="text" name="dampak" value="{{ old('dampak') }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Status Kejadian</label>
                        <select name="status_kejadian" class="form-select">
                            <option value="">Pilih Status</option>
                            <option value="aktif" {{ old('status_kejadian') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ old('status_kejadian') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dalam_penanganan" {{ old('status_kejadian') == 'dalam_penanganan' ? 'selected' : '' }}>Dalam Penanganan</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Upload Foto / Berita Acara</label>
                        <input type="file" name="media" class="form-control">
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('kejadian.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
