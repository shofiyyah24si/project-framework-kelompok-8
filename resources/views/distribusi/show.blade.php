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
                            <div class="mb-4">
                                <h2 class="h4 mb-2 fw-bold text-dark">Distribusi #{{ $distribusi->distribusi_id }}</h2>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Tanggal: {{ optional($distribusi->tanggal)->format('d F Y') }}
                                </p>
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
                                                Barang yang didistribusikan
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- JUMLAH DISTRIBUSI --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-123 text-success fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Jumlah</h6>
                                            <div class="d-flex align-items-center">
                                                <span class="h4 fw-bold text-success me-2">{{ $distribusi->jumlah ?? 0 }}</span>
                                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1">
                                                    {{ $distribusi->logistik->satuan ?? 'Unit' }}
                                                </span>
                                            </div>
                                            <small class="text-muted">
                                                Jumlah yang didistribusikan
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- PENERIMA --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-person-check text-info fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Penerima</h6>
                                            <p class="mb-0 fw-medium">{{ $distribusi->penerima ?? '-' }}</p>
                                            <small class="text-muted">
                                                Warga penerima
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- POSKO TUJUAN (DIPERBAIKI) --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-geo-alt text-warning fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Posko Tujuan</h6>
                                            <p class="mb-0 fw-medium">{{ $distribusi->posko->nama ?? '-' }}</p>
                                            <small class="text-muted">
                                                {{ $distribusi->posko->alamat ?? 'Lokasi tidak tersedia' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- TANGGAL DISTRIBUSI --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-calendar-event text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Tanggal Distribusi</h6>
                                            <p class="mb-0 fw-medium">{{ optional($distribusi->tanggal)->format('d/m/Y') }}</p>
                                            <small class="text-muted">
                                                Waktu: {{ optional($distribusi->created_at)->format('H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- ID DISTRIBUSI --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-hash text-secondary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">ID Distribusi</h6>
                                            <p class="mb-0 fw-medium">
                                                <code class="text-dark">#{{ $distribusi->distribusi_id }}</code>
                                            </p>
                                            <small class="text-muted">
                                                Kode identifikasi
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
                                                <p class="mb-0">{{ $distribusi->keterangan }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- INFORMASI SISTEM --}}
                            <div class="border-top pt-4 mt-3">
                                <h6 class="fw-semibold mb-3 text-dark">Informasi Sistem</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar-plus text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Dibuat</small>
                                                <span class="fw-medium">
                                                    @if($distribusi->created_at)
                                                        {{ \Carbon\Carbon::parse($distribusi->created_at)->format('d/m/Y H:i') }}
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
                                                    @if($distribusi->updated_at)
                                                        {{ \Carbon\Carbon::parse($distribusi->updated_at)->format('d/m/Y H:i') }}
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

                {{-- KOLOM KANAN - INFORMASI TAMBAHAN --}}
                <div class="col-lg-4">
                    {{-- INFORMASI DISTRIBUSI --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="bi bi-info-circle me-2 text-primary"></i>
                                Informasi Distribusi
                            </h6>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-3">
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
                                        <small class="text-muted d-block">Sisa Stok Logistik</small>
                                        <span class="fw-medium">{{ $distribusi->logistik->stok ?? 0 }} {{ $distribusi->logistik->satuan ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- INFORMASI LOGISTIK TERKAIT --}}
                    @if($distribusi->logistik)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-dark">
                                    <i class="bi bi-box-seam me-2 text-danger"></i>
                                    Informasi Logistik Terkait
                                </h6>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-box text-danger"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Nama Barang</small>
                                            <span class="fw-medium">{{ $distribusi->logistik->nama_barang ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-box-seam text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Stok & Satuan</small>
                                            <span class="fw-medium">{{ $distribusi->logistik->stok ?? 0 }} {{ $distribusi->logistik->satuan ?? 'Unit' }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-building text-info"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Sumber</small>
                                            <span class="fw-medium">{{ $distribusi->logistik->sumber ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="my-3">
                                
                                <a href="{{ route('logistik.show', $distribusi->logistik->logistik_id) }}" 
                                   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-arrow-right me-1"></i> Lihat Detail Logistik
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- KEJADIAN TERKAIT --}}
                    @if($distribusi->logistik && $distribusi->logistik->kejadian)
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-dark">
                                    <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                                    Kejadian Bencana Terkait
                                </h6>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-fire text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Jenis Bencana</small>
                                            <span class="fw-medium">{{ $distribusi->logistik->kejadian->jenis_bencana ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-info bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-geo-alt text-info"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Lokasi</small>
                                            <span class="fw-medium">{{ $distribusi->logistik->kejadian->lokasi_text ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-calendar3 text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Tanggal</small>
                                            <span class="fw-medium">
                                                @if($distribusi->logistik->kejadian->tanggal)
                                                    {{ \Carbon\Carbon::parse($distribusi->logistik->kejadian->tanggal)->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="my-3">
                                
                                <a href="{{ route('kejadian.show', $distribusi->logistik->kejadian->kejadian_id) }}" 
                                   class="btn btn-outline-warning btn-sm w-100">
                                    <i class="bi bi-arrow-right me-1"></i> Lihat Detail Kejadian
                                </a>
                            </div>
                        </div>
                    @endif
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
    
    .border-top {
        border-top: 1px solid #dee2e6 !important;
    }
    
    code {
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-family: 'Courier New', monospace;
    }
    
    .h4 {
        color: #212529;
    }
</style>
@endpush