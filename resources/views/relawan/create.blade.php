@extends('layouts.kaiadmin')

@section('page_title', 'Tambah Relawan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">Tambah Relawan</div>
        <div class="card-body">
            <form action="{{ route('relawan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Keahlian</label>
                    <input type="text" name="keahlian" class="form-control">
                </div>
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('relawan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
