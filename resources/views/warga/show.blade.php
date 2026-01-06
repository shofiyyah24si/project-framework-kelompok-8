@extends('layouts.app')

@section('title', 'Detail Data Warga')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold">Detail Data Warga</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-person-lines-fill me-1"></i>
                        Informasi lengkap data warga
                    </p>
                </div>
                <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="row">
                {{-- KOLOM KIRI - INFORMASI UTAMA --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            {{-- HEADER DENGAN JENIS KELAMIN --}}
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    @php
                                        $badgeClass = $warga->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-pink';
                                        $jenisKelamin = $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                                    @endphp
                                    
                                    <span class="badge {{ $badgeClass }} px-3 py-2 mb-2">
                                        <i class="bi bi-person-fill me-1"></i>
                                        {{ $jenisKelamin }}
                                    </span>
                                    <h2 class="h4 mb-2 fw-bold text-dark">{{ $warga->nama }}</h2>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-person-badge me-1"></i>
                                        NIK: {{ $warga->no_ktp }}
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                {{-- AGAMA --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-book text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Agama</h6>
                                            <p class="mb-0">{{ $warga->agama ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- PEKERJAAN --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-briefcase text-info fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2 text-dark">Pekerjaan</h6>
                                            <p class="mb-0 fw-medium">{{ $warga->pekerjaan ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- TELEPON --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-telephone text-success fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold mb-2 text-dark">Nomor Telepon</h6>
                                            <p class="mb-0">
                                                @if($warga->telp)
                                                    {{ $warga->telp }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- EMAIL --}}
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="bi bi-envelope text-warning fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold mb-2 text-dark">Email</h6>
                                            <p class="mb-0">
                                                @if($warga->email)
                                                    {{ $warga->email }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
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
                                    <span class="text-muted small">ID Warga</span>
                                    <span class="badge bg-light text-dark fw-medium">#{{ $warga->warga_id }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">Dibuat</span>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($warga->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Terakhir Diupdate</span>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($warga->updated_at)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            
                            <hr class="my-3">
                            
                            {{-- STATUS DATA --}}
                            <div class="mb-3">
                                <h6 class="fw-bold mb-3 text-dark">
                                    <i class="bi bi-check-circle me-2 text-success"></i>
                                    Status Data
                                </h6>
                                
                                <div class="d-flex align-items-center mb-2">
                                    <div class="{{ $badgeClass }} bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-person {{ $warga->jenis_kelamin == 'L' ? 'text-primary' : 'text-pink' }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Jenis Kelamin</small>
                                        <span class="fw-medium">{{ $jenisKelamin }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-success bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-telephone text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Kontak Telepon</small>
                                        <span class="fw-medium">{{ $warga->telp ? 'Tersedia' : 'Tidak ada' }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-envelope text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">Email</small>
                                        <span class="fw-medium">{{ $warga->email ? 'Tersedia' : 'Tidak ada' }}</span>
                                    </div>
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
    
    .bg-pink {
        background-color: #e83e8c !important;
    }
    
    .text-pink {
        color: #e83e8c !important;
    }
    
    .text-dark {
        color: #212529 !important;
    }
    
    .fw-semibold {
        font-weight: 600 !important;
    }
</style>
@endpush