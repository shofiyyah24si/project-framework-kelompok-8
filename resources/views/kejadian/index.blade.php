@extends('layouts.app')

@section('title', 'Data Kejadian Bencana')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-exclamation-triangle"></i> Data Kejadian Bencana
        </h3>
        <a href="{{ route('kejadian-bencana.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kejadian
        </a>
    </div>

    {{-- ✅ Flash message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ✅ Jika data kosong --}}
    @if ($kejadian->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> Belum ada data kejadian bencana.
        </div>
    @else
        {{-- ✅ Tampilkan data dalam bentuk card grid --}}
        <div class="row g-4">
            @foreach ($kejadian as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        {{-- Foto kejadian --}}
                        @if ($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}"
                                 class="card-img-top"
                                 alt="{{ $item->jenis_bencana }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('template/assets/img/no-image.jpg') }}"
                                 class="card-img-top"
                                 alt="No Image"
                                 style="height: 200px; object-fit: cover;">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">
                                {{ ucfirst($item->jenis_bencana) }}
                            </h5>
                            <p class="mb-1"><i class="bi bi-calendar-event"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                            </p>
                            <p class="mb-1"><i class="bi bi-geo-alt"></i> {{ $item->lokasi_text }}</p>
                            <p class="mb-1"><i class="bi bi-house"></i> RT {{ $item->rt ?? '-' }}, RW {{ $item->rw ?? '-' }}</p>
                            <p class="mb-2"><i class="bi bi-exclamation-octagon"></i> Dampak: {{ $item->dampak ?? '-' }}</p>

                            {{-- Status dengan badge warna --}}
                            @if ($item->status_kejadian == 'Selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif ($item->status_kejadian == 'Proses')
                                <span class="badge bg-warning text-dark">Proses</span>
                            @elseif ($item->status_kejadian == 'Aktif')
                                <span class="badge bg-danger">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Diketahui</span>
                            @endif

                            {{-- Keterangan --}}
                            @if ($item->keterangan)
                                <p class="mt-2 text-muted small"><i class="bi bi-info-circle"></i> {{ $item->keterangan }}</p>
                            @endif
                        </div>

                        {{-- Tombol aksi --}}
                        <div class="card-footer bg-light border-0 d-flex justify-content-between">
                            <a href="{{ route('kejadian-bencana.edit', $item->kejadian_id) }}"
                               class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('kejadian-bencana.destroy', $item->kejadian_id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ✅ Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $kejadian->links() }}
        </div>
    @endif
</div>
@endsection
