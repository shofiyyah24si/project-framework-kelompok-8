@extends('layouts.app')

@section('title', 'Data Distribusi Logistik')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Data Distribusi Logistik</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-truck me-1"></i>
                        Monitoring penyaluran logistik ke posko bencana.
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
                    <form method="GET" action="{{ route('distribusi.index') }}">
                        <div class="row g-3 align-items-end">
                            {{-- PENCARIAN --}}
                            <div class="col-lg-4">
                                <label class="form-label fw-medium text-dark mb-1">Pencarian</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text"
                                           name="search"
                                           class="form-control border-start-0"
                                           value="{{ request('search') }}"
                                           placeholder="Cari penerima, logistik, posko...">
                                </div>
                            </div>

                            {{-- FILTER TANGGAL --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Tanggal</label>
                                <input type="date" 
                                       name="tanggal" 
                                       class="form-control" 
                                       value="{{ request('tanggal') }}">
                            </div>

                            {{-- FILTER LOGISTIK --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Logistik</label>
                                <select name="logistik_id" class="form-select">
                                    <option value="">Semua Logistik</option>
                                    @foreach ($listLogistik as $logistik)
                                        <option value="{{ $logistik->logistik_id }}" {{ request('logistik_id') == $logistik->logistik_id ? 'selected' : '' }}>
                                            {{ $logistik->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- FILTER POSKO --}}
                            <div class="col-lg-2">
                                <label class="form-label fw-medium text-dark mb-1">Posko</label>
                                <select name="posko_id" class="form-select">
                                    <option value="">Semua Posko</option>
                                    @foreach ($listPosko as $posko)
                                        <option value="{{ $posko->posko_id }}" {{ request('posko_id') == $posko->posko_id ? 'selected' : '' }}>
                                            {{ $posko->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="col-lg-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="bi bi-funnel me-2"></i> Filter
                                    </button>
                                    <a href="{{ route('distribusi.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- INFO JUMLAH DATA --}}
            @if($data->count())
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Ditemukan <strong>{{ $data->total() }}</strong> distribusi
                    </div>
                    <div class="text-muted small">
                        Halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }}
                    </div>
                </div>

                {{-- GRID CARD DATA --}}
                <div class="row g-4">
                    @foreach($data as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                {{-- CARD HEADER --}}
                                <div class="card-header bg-white border-0 pb-0 pt-3 px-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            @if($item->tanggal)
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h5 class="card-title mb-2 text-dark fw-bold">
                                        {{ $item->penerima ?? '-' }}
                                    </h5>
                                </div>

                                {{-- CARD BODY --}}
                                <div class="card-body py-2 px-3">
                                    {{-- LOGISTIK --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-box-seam text-muted mt-1 me-2"></i>
                                                <div>
                                                    <p class="mb-0 fw-medium text-dark">Logistik</p>
                                                    <small class="text-muted">
                                                        {{ $item->logistik->nama_barang ?? '-' }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted">
                                                    Stok: {{ $item->logistik->stok ?? 0 }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- JUMLAH --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-123 text-muted mt-1 me-2"></i>
                                                <div>
                                                    <p class="mb-0 fw-medium text-dark">Jumlah</p>
                                                    <small class="text-muted">Barang didistribusikan</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <h4 class="mb-0 fw-bold text-primary">
                                                    {{ $item->jumlah ?? 0 }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- POSKO TUJUAN --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-geo-alt text-muted mt-1 me-2"></i>
                                            <div>
                                                <p class="mb-0 text-dark fw-medium">Posko Tujuan</p>
                                                <small class="text-muted">
                                                    @if($item->posko)
                                                        {{ $item->posko->nama ?? '-' }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BUKTI DISTRIBUSI --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-paperclip text-muted mt-1 me-2"></i>
                                            <div>
                                                <p class="mb-0 text-dark fw-medium">Bukti Distribusi</p>
                                                <small class="{{ $item->bukti_distribusi ? 'text-primary' : 'text-muted' }}">
                                                    {{ $item->bukti_distribusi ? 'Tersedia' : 'Tidak ada bukti' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- CARD FOOTER (TOMBOL AKSI) --}}
                                <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('distribusi.show', $item->distribusi_id) }}"
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
                @if($data->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <div class="text-muted small">
                            <i class="bi bi-list-ul me-1"></i>
                            Data {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() ?? 0 }}
                        </div>

                        <nav aria-label="Navigasi halaman">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- PREVIOUS --}}
                                @if($data->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link border-0">
                                            <i class="bi bi-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link border-0" href="{{ $data->previousPageUrl() }}">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- PAGE NUMBERS --}}
                                @for ($page = 1; $page <= $data->lastPage(); $page++)
                                    @if($page == $data->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $data->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                {{-- NEXT --}}
                                @if($data->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link border-0" href="{{ $data->nextPageUrl() }}">
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
                            <i class="bi bi-truck display-4 text-muted"></i>
                        </div>
                        <h5 class="text-dark mb-3">Belum Ada Data Distribusi</h5>
                        <p class="text-muted mb-4">
                            Tidak ada data distribusi logistik yang ditemukan sesuai filter.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('distribusi.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i> Reset Filter
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- STATISTIK CEPAT (SINKRON DASHBOARD) --}}
            <div class="row mt-4 g-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-truck text-primary fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Total Distribusi</h6>
                                    <p class="text-muted small mb-0">Item terdistribusi</p>
                                </div>
                                <div class="fs-4 fw-bold text-primary">
                                    {{ $totalDistribusi }}
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
                                    <i class="bi bi-calendar-check text-success fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Distribusi Hari Ini</h6>
                                    <p class="text-muted small mb-0">{{ now()->format('d/m/Y') }}</p>
                                </div>
                                <div class="fs-4 fw-bold text-success">
                                    {{ $distribusiHariIni }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-list-check text-info fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Total Transaksi</h6>
                                    <p class="text-muted small mb-0">Jumlah pengeluaran</p>
                                </div>
                                <div class="fs-4 fw-bold text-info">
                                    {{ $totalDistribusiCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    
    .card-title {
        font-size: 1.1rem;
        line-height: 1.4;
    }
</style>
@endpush