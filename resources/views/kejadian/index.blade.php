@extends('layouts.kaiadmin')

@section('page_title', 'Data Kejadian Bencana')

@section('content')
<div class="page-inner mt-4">

    <!-- Judul Utama (Tengah dan Profesional) -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary mb-2" style="font-size: 2rem;">
            Sistem Kebencanaan & Tanggap Darurat
        </h1>
        <p class="text-muted mb-0" style="font-size: 1rem;">
            Kelola dan pantau data kejadian bencana secara cepat, akurat, dan profesional
        </p>
        <hr class="mx-auto mt-3" style="width: 250px; border-top: 3px solid #007bff;">
    </div>

    <!-- Card Data Kejadian Bencana -->
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Data Kejadian Bencana</h5>
            <a href="{{ route('kejadian.create') }}" class="btn btn-light btn-sm">
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
                            <th>Jenis Bencana</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kejadian as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->jenis_bencana }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                <td>{{ $item->lokasi_text }}</td>
                                <td>
                                    <span class="badge 
                                        @if($item->status_kejadian == 'Selesai') bg-success 
                                        @elseif($item->status_kejadian == 'Proses') bg-warning text-dark 
                                        @else bg-info text-dark 
                                        @endif">
                                        {{ $item->status_kejadian }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('kejadian.edit', $item->kejadian_id) }}" 
                                       class="btn btn-sm btn-warning me-1" title="Edit">
                                       <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kejadian.destroy', $item->kejadian_id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Hapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data bencana</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $kejadian->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
