@extends('layouts.app')

@section('title', 'Detail Distribusi Logistik')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Detail Distribusi Logistik</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-clipboard-check me-1"></i>
                        Informasi lengkap distribusi logistik
                    </p>
                </div>
                <a href="{{ route('distribusi.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="row">
                {{-- KOLOM KIRI - INFORMASI UTAMA --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        {{-- BUKTI DISTRIBUSI --}}
                        @if ($distribusi->bukti_distribusi)
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $distribusi->bukti_distribusi) }}"
                                     class="card-img-top rounded-top"
                                     alt="Bukti distribusi"
                                     style="height: 300px; object-fit: cover; width: 100%;">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <a href="{{ asset('storage/' . $distribusi->bukti_distribusi) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-light shadow-sm">
                                        <i class="bi bi-arrows-fullscreen me-1"></i> Fullscreen
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="card-body">
                            {{-- HEADER --}}
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <span class="badge bg-primary px-3 py-2 mb-2">
                                        <i class="bi bi-truck me-1"></i>
                                        Distribusi Logistik
                                    </span>
                                    <h2 class="h4 mb-2 fw-bold text-dark">Distribusi #{{ $distribusi->distribusi_id }}</h2>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Tanggal: {{ optional($distribusi->tanggal)->format('d F Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                {{-- LOGISTIK --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-box-seam text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Logistik</h6>
                                            <p class="mb-0 fw-medium">{{ $distribusi->logistik->nama_barang ?? '-' }}</p>
                                            <small class="text-muted">
                                                Stok: {{ $distribusi->logistik->stok ?? 0 }} {{ $distribusi->logistik->satuan ?? '' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- JUMLAH --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-123 text-success fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Jumlah</h6>
                                            <p class="mb-0 fw-medium text-success fs-5">{{ $distribusi->jumlah ?? 0 }}</p>
                                            <small class="text-muted">
                                                {{ $distribusi->logistik->satuan ?? 'unit' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- PENERIMA --}}
                                <div class="col-12 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-person-check text-info fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Penerima</h6>
                                            <p class="mb-0 fw-medium">{{ $distribusi->penerima ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- POSKO TUJUAN --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-geo-alt text-warning fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Posko Tujuan</h6>
                                            <p class="mb-0">{{ $distribusi->posko->nama_posko ?? '-' }}</p>
                                            <small class="text-muted">
                                                {{ $distribusi->posko->lokasi ?? 'Lokasi tidak tersedia' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- TANGGAL --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-calendar-event text-secondary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Tanggal Distribusi</h6>
                                            <p class="mb-0 fw-medium">{{ optional($distribusi->tanggal)->format('d/m/Y') }}</p>
                                            <small class="text-muted">
                                                {{ optional($distribusi->created_at)->format('H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- KETERANGAN --}}
                                @if($distribusi->keterangan)
                                    <div class="col-12 mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-light bg-opacity-10 p-3 rounded-circle me-3">
                                                <i class="bi bi-chat-left-text text-dark fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-2 text-dark">Keterangan</h6>
                                                <p class="mb-0">
                                                    {{ $distribusi->keterangan }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN - INFO SISTEM --}}
                <div class="col-lg-4">
                    {{-- INFO SISTEM --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="bi bi-info-circle me-2 text-primary"></i>
                                Informasi Sistem
                            </h6>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">ID Distribusi</span>
                                    <span class="badge bg-light text-dark fw-medium">#{{ $distribusi->distribusi_id }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">Dibuat</span>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($distribusi->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Terakhir Diupdate</span>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($distribusi->updated_at)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            
                            <hr class="my-3">
                            
                            {{-- STATUS SISTEM --}}
                            <div class="mb-3">
                                <h6 class="fw-bold mb-3 text-dark">
                                    <i class="bi bi-graph-up me-2 text-success"></i>
                                    Status Sistem
                                </h6>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-truck text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Status Distribusi</small>
                                        <span class="badge bg-primary">Tersalurkan</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-info bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-camera text-info"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Bukti Distribusi</small>
                                        <span class="fw-medium">{{ $distribusi->bukti_distribusi ? 'Tersedia' : 'Tidak ada' }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-box text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Sisa Stok</small>
                                        <span class="fw-medium">{{ $distribusi->logistik->stok ?? 0 }} {{ $distribusi->logistik->satuan ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- LOGISTIK TERKAIT --}}
                            @if($distribusi->logistik)
                                <hr class="my-3">
                                
                                <div class="mb-3">
                                    <h6 class="fw-bold mb-3 text-dark">
                                        <i class="bi bi-box me-2 text-danger"></i>
                                        Informasi Logistik
                                    </h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-tag text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Status Logistik</small>
                                            <span class="badge bg-{{ $distribusi->logistik->status == 'tersedia' ? 'success' : 'warning' }}">
                                                {{ $distribusi->logistik->status ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-box-seam text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Satuan</small>
                                            <span class="fw-medium">{{ $distribusi->logistik->satuan ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
    
    .position-relative {
        border-radius: 0.75rem 0.75rem 0 0;
        overflow: hidden;
    }
    
    .card-img-top {
        border-radius: 0.75rem 0.75rem 0 0;
    }
    
    .text-dark {
        color: #212529 !important;
    }
    
    .fw-semibold {
        font-weight: 600 !important;
    }
    
    a.text-decoration-none:hover {
        text-decoration: underline !important;
        color: #0d6efd !important;
    }
</style>
@endpush