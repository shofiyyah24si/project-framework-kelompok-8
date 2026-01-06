@extends('layouts.app')

@section('title', 'Detail Logistik Bencana')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Detail Logistik Bencana</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-box-seam me-1"></i>
                        Informasi lengkap logistik bencana
                    </p>
                </div>
                <a href="{{ route('logistik.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
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

            <div class="row">
                {{-- KOLOM KIRI - INFORMASI UTAMA --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            {{-- HEADER --}}
                            <div class="mb-4">
                                <h2 class="h4 mb-2 fw-bold text-dark">{{ $logistik->nama_barang ?? '-' }}</h2>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-building me-1"></i>
                                    Sumber: {{ $logistik->sumber ?? '-' }}
                                </p>
                            </div>

                            <div class="row">
                                {{-- STOK & SATUAN --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-box-seam text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Stok & Satuan</h6>
                                            <div class="d-flex align-items-center">
                                                <span class="h4 fw-bold text-primary me-2">{{ $logistik->stok ?? 0 }}</span>
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1">
                                                    {{ $logistik->satuan ?? 'Unit' }}
                                                </span>
                                            </div>
                                            <small class="text-muted">
                                                Jumlah tersedia
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- SUMBER --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-building text-info fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Sumber Logistik</h6>
                                            <p class="mb-0 fw-medium">{{ $logistik->sumber ?? '-' }}</p>
                                            <small class="text-muted">
                                                Asal barang
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- KEJADIAN TERKAIT --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-exclamation-triangle text-warning fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Kejadian Terkait</h6>
                                            @if($logistik->kejadian)
                                                <p class="mb-0 fw-medium">{{ $logistik->kejadian->jenis_bencana ?? '-' }}</p>
                                                <small class="text-muted">
                                                    Bencana terkait
                                                </small>
                                            @else
                                                <p class="mb-0 fw-medium text-muted">-</p>
                                                <small class="text-muted">
                                                    Tidak terkait kejadian
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- ID LOGISTIK --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-hash text-secondary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">ID Logistik</h6>
                                            <p class="mb-0 fw-medium">
                                                <code class="text-dark">#{{ $logistik->logistik_id }}</code>
                                            </p>
                                            <small class="text-muted">
                                                Kode identifikasi
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TANGGAL PEMBUATAN & UPDATE --}}
                            <div class="border-top pt-4 mt-3">
                                <h6 class="fw-semibold mb-3 text-dark">Informasi Sistem</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar-plus text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Dibuat</small>
                                                <span class="fw-medium">
                                                    @if($logistik->created_at)
                                                        {{ \Carbon\Carbon::parse($logistik->created_at)->format('d/m/Y H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-arrow-clockwise text-success me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Terakhir Diupdate</small>
                                                <span class="fw-medium">
                                                    @if($logistik->updated_at)
                                                        {{ \Carbon\Carbon::parse($logistik->updated_at)->format('d/m/Y H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN - KEJADIAN & STATUS --}}
                <div class="col-lg-4">
                    {{-- INFO KEJADIAN TERKAIT DETAIL --}}
                    @if($logistik->kejadian)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-dark">
                                    <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                                    Detail Kejadian Terkait
                                </h6>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-fire text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Jenis Bencana</small>
                                            <span class="fw-medium">{{ $logistik->kejadian->jenis_bencana ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-info bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-geo-alt text-info"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Lokasi</small>
                                            <span class="fw-medium">{{ $logistik->kejadian->lokasi_text ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-calendar3 text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Tanggal</small>
                                            <span class="fw-medium">
                                                @if($logistik->kejadian->tanggal)
                                                    {{ \Carbon\Carbon::parse($logistik->kejadian->tanggal)->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-flag text-danger"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Status</small>
                                            <span class="badge 
                                                @if($logistik->kejadian->status_kejadian == 'Baru') bg-danger
                                                @elseif($logistik->kejadian->status_kejadian == 'Proses') bg-warning text-dark
                                                @elseif($logistik->kejadian->status_kejadian == 'Selesai') bg-success
                                                @else bg-secondary @endif">
                                                {{ $logistik->kejadian->status_kejadian ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="my-3">
                                
                                <a href="{{ route('kejadian.show', $logistik->kejadian->kejadian_id) }}" 
                                   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-arrow-right me-1"></i> Lihat Detail Kejadian
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-dark">
                                    <i class="bi bi-exclamation-triangle me-2 text-secondary"></i>
                                    Kejadian Terkait
                                </h6>
                                <div class="text-center py-3">
                                    <i class="bi bi-link-slash display-4 text-muted mb-3"></i>
                                    <p class="text-muted mb-3">Logistik ini tidak terkait dengan kejadian bencana tertentu</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- HAPUS CARD STATUS STOK --}}
                    {{-- <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="bi bi-graph-up me-2 text-primary"></i>
                                Status Stok
                            </h6>
                            
                            {{-- PROGRESS BAR STOK --}}
                            {{-- @php
                                $stokPersen = 0;
                                if($stok > 0) {
                                    $stokPersen = ($stok / 100) * 100;
                                    if($stokPersen > 100) $stokPersen = 100;
                                }
                            @endphp
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted small">Level Stok</span>
                                    <span class="fw-medium">{{ $stok }} {{ $logistik->satuan ?? 'unit' }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar 
                                        @if($stok <= 0) bg-danger
                                        @elseif($stok <= 10) bg-warning
                                        @elseif($stok <= 50) bg-info
                                        @else bg-success @endif"
                                        role="progressbar" 
                                        style="width: {{ $stokPersen }}%"
                                        aria-valuenow="{{ $stokPersen }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">0</small>
                                    <small class="text-muted">100+</small>
                                </div>
                            </div>
                            
                            <hr class="my-3">
                            
                            {{-- PERINGATAN SISTEM --}}
                            {{-- <h6 class="fw-bold mb-3 text-dark">
                                <i class="bi bi-bell me-2 text-warning"></i>
                                Peringatan Sistem
                            </h6>
                            
                            @if($stok <= 10 && $stok > 0)
                                <div class="alert alert-warning alert-dismissible fade show py-2 mb-3" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        <div>
                                            <small class="fw-bold d-block">Stok Menipis</small>
                                            <small>Stok hanya tersisa {{ $stok }} {{ $logistik->satuan ?? 'unit' }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($stok <= 0)
                                <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-x-circle-fill me-2"></i>
                                        <div>
                                            <small class="fw-bold d-block">Stok Habis</small>
                                            <small>Barang ini sudah habis, perlu restok</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($stok > 50)
                                <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        <div>
                                            <small class="fw-bold d-block">Stok Aman</small>
                                            <small>Stok cukup untuk kebutuhan saat ini</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($stok > 10 && $stok <= 50)
                                <div class="alert alert-info alert-dismissible fade show py-2" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <div>
                                            <small class="fw-bold d-block">Stok Terbatas</small>
                                            <small>Stok terbatas, perlu monitoring</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div> --}}
                </div>
            </div>

        </div>
    </main>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 0.75rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .badge {
        font-size: 0.8rem;
        letter-spacing: 0.3px;
    }
    
    .rounded-circle {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    hr {
        opacity: 0.1;
    }
    
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #6c757d;
    }
    
    .text-dark {
        color: #212529 !important;
    }
    
    .fw-semibold {
        font-weight: 600 !important;
    }
    
    .alert {
        border-radius: 0.5rem;
        margin-bottom: 0.75rem;
    }
    
    .h4 {
        color: #212529;
    }
    
    code {
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-family: 'Courier New', monospace;
    }
    
    .progress {
        border-radius: 4px;
    }
    
    .progress-bar {
        border-radius: 4px;
    }
    
    .border-top {
        border-top: 1px solid #dee2e6 !important;
    }
</style>
@endpush