@extends('admin.layouts.admin.app')
@section('title', 'Edit Warga')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-4">Edit Data Warga</h4>
    <form action="{{ route('admin.warga.update', $warga->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" value="{{ $warga->nama }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" rows="3">{{ $warga->alamat }}</textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">No HP</label>
        <input type="text" name="no_hp" class="form-control" value="{{ $warga->no_hp }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Pekerjaan</label>
        <input type="text" name="pekerjaan" class="form-control" value="{{ $warga->pekerjaan }}">
      </div>
      <div class="text-end">
        <a href="{{ route('admin.warga.index') }}" class="btn btn-light">Batal</a>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>
@endsection
