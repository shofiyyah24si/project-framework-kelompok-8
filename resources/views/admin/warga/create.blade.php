@extends('admin.layouts.admin.app')
@section('title', 'Tambah Warga')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-4">Tambah Data Warga</h4>
    <form action="{{ route('warga.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">No HP</label>
        <input type="text" name="no_hp" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Pekerjaan</label>
        <input type="text" name="pekerjaan" class="form-control">
      </div>
      <div class="text-end">
        <a href="{{ route('warga.index') }}" class="btn btn-light">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
