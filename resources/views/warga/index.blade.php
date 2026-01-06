@extends('layouts.app')

@section('title', 'Data Warga')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Data Warga</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-people me-1"></i>
                        Monitoring data warga berdasarkan laporan yang masuk.
                    </p>
                </div>
            </div>

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div class="flex-grow-1">
                            <strong class="fw-semibold">Berhasil!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- CARD FILTER --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('warga.index') }}">
                        <div class="row g-3 align-items-end">
                            {{-- PENCARIAN --}}
                            <div class="col-lg-5">
                                <label class="form-label fw-medium text-dark mb-1">Pencarian</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text"
                                           name="search"
                                           class="form-control border-start-0"
                                           value="{{ request('search') }}"
                                           placeholder="Cari nama, NIK, atau pekerjaan...">
                                </div>
                            </div>

                            {{-- FILTER JENIS KELAMIN --}}
                            <div class="col-lg-3">
                                <label class="form-label fw-medium text-dark mb-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            {{-- FILTER PEKERJAAN --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Pekerjaan</label>
                                <input type="text" 
                                       name="pekerjaan" 
                                       class="form-control"
                                       value="{{ request('pekerjaan') }}"
                                       placeholder="Ketik...">
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="col-lg-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="bi bi-funnel me-2"></i> Filter
                                    </button>
                                    <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- INFO JUMLAH DATA --}}
            @if($wargas->count())
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Ditemukan <strong>{{ $wargas->total() }}</strong> data warga
                    </div>
                    <div class="text-muted small">
                        Halaman {{ $wargas->currentPage() }} dari {{ $wargas->lastPage() }}
                    </div>
                </div>

                {{-- GRID CARD DATA --}}
                <div class="row g-4">
                    @foreach($wargas as $item)
                        @php
                            $badgeClass = $item->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-pink';
                            $jenisKelamin = $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                {{-- CARD HEADER --}}
                                <div class="card-header bg-white border-0 pb-0 pt-3 px-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge {{ $badgeClass }} px-3 py-2 fw-medium">
                                            {{ $jenisKelamin }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $item->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    
                                    <h5 class="card-title mb-2 text-dark fw-bold">
                                        {{ $item->nama }}
                                    </h5>
                                    <small class="text-muted">
                                        <i class="bi bi-person-badge me-1"></i>
                                        NIK: {{ substr($item->no_ktp, 0, 4) }}***{{ substr($item->no_ktp, -4) }}
                                    </small>
                                </div>

                                {{-- CARD BODY --}}
                                <div class="card-body py-2 px-3">
                                    {{-- AGAMA --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-book text-muted mt-1 me-2"></i>
                                            <div>
                                                <small class="text-muted d-block mb-1">Agama</small>
                                                <p class="mb-0 text-dark fw-medium">
                                                    {{ $item->agama ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PEKERJAAN --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-briefcase text-muted mt-1 me-2"></i>
                                            <div>
                                                <small class="text-muted d-block mb-1">Pekerjaan</small>
                                                <p class="mb-0 text-dark fw-medium">
                                                    {{ $item->pekerjaan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- KONTAK --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-telephone text-muted mt-1 me-2"></i>
                                            <div>
                                                <small class="text-muted d-block mb-1">Kontak</small>
                                                <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                                                    @if($item->telp)
                                                        {{ $item->telp }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- CARD FOOTER (TOMBOL AKSI) --}}
                                <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        {{-- TOMBOL DETAIL SAJA --}}
                                        <div>
                                            <a href="{{ route('warga.show', $item->warga_id) }}"
                                               class="btn btn-outline-primary btn-sm"
                                               title="Detail">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                @if($wargas->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <div class="text-muted small">
                            <i class="bi bi-list-ul me-1"></i>
                            Data {{ $wargas->firstItem() ?? 0 }} - {{ $wargas->lastItem() ?? 0 }} dari {{ $wargas->total() ?? 0 }}
                        </div>

                        <nav aria-label="Navigasi halaman">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- PREVIOUS --}}
                                @if($wargas->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link border-0">
                                            <i class="bi bi-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link border-0" href="{{ $wargas->previousPageUrl() }}">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- PAGE NUMBERS --}}
                                @for ($page = 1; $page <= $wargas->lastPage(); $page++)
                                    @if($page == $wargas->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $wargas->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                {{-- NEXT --}}
                                @if($wargas->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link border-0" href="{{ $wargas->nextPageUrl() }}">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link border-0">
                                            <i class="bi bi-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            @else
                {{-- EMPTY STATE --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-people display-4 text-muted"></i>
                        </div>
                        <h5 class="text-dark mb-3">Belum Ada Data Warga</h5>
                        <p class="text-muted mb-4">
                            Tidak ada data warga yang ditemukan sesuai filter.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i> Reset Filter
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- STATISTIK CEPAT --}}
            @if($wargas->count())
                <div class="row mt-4 g-3">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-person-fill text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Laki-laki</h6>
                                        <p class="text-muted small mb-0">Jumlah warga laki-laki</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-primary">
                                        {{ $wargas->where('jenis_kelamin', 'L')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-pink bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-person-hearts text-pink fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Perempuan</h6>
                                        <p class="text-muted small mb-0">Jumlah warga perempuan</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-pink">
                                        {{ $wargas->where('jenis_kelamin', 'P')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-people-fill text-success fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Total Warga</h6>
                                        <p class="text-muted small mb-0">Semua data warga</p>
                                    </div>
                                    <div class="fs-4 fw-bold text-success">
                                        {{ $wargas->total() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </main>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 0.5rem;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    
    .badge {
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }
    
    .bg-pink {
        background-color: #e83e8c !important;
    }
    
    .text-pink {
        color: #e83e8c !important;
    }
    
    .page-link {
        border-radius: 0.375rem;
        margin: 0 2px;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-outline-primary:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }
</style>
@endpush