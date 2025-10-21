@extends('layouts.kaiadmin')

@section('page_title', 'Data Relawan')

@section('content')
<div class="page-inner mt-4">

    <!-- Judul Utama (Tengah dan Profesional) -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-success mb-2" style="font-size: 2rem;">
            Sistem Kebencanaan & Tanggap Darurat
        </h1>
        <p class="text-muted mb-0" style="font-size: 1rem;">
            Kelola data relawan dengan mudah dan profesional untuk mendukung penanganan kebencanaan
        </p>
        <hr class="mx-auto mt-3" style="width: 250px; border-top: 3px solid #28a745;">
    </div>

    <!-- Card Data Relawan -->
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-hands-helping me-2"></i> Data Relawan</h5>
            <a href="{{ route('relawan.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Keahlian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($relawan as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold text-dark">{{ $item->nama }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->no_hp }}</td>
                                <td>{{ $item->keahlian ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('relawan.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning me-1" title="Edit">
                                       <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('relawan.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Hapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data relawan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
