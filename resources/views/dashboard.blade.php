@extends('layouts.app')

@section('title', 'Dashboard - Sistem Manajemen Bencana')

@section('content')
<main class="py-5 bg-light">
    <div class="container">
        <!-- Header Minimalis -->
        <div class="mb-5">
            <h1 class="h3 mb-1 fw-bold">Dashboard</h1>
            <p class="text-muted mb-0">
                <i class="bi bi-speedometer2 me-1"></i>
                Ringkasan informasi sistem manajemen bencana
            </p>
            <div class="mt-1 small text-muted">
                <i class="bi bi-calendar3 me-1"></i>
                {{ now()->format('d F Y') }}
            </div>
        </div>

        <!-- ========== KPI CARDS SIMPLE ========== -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="h2 fw-bold text-primary mb-2">{{ $totalKejadian }}</div>
                        <div class="text-muted">Kejadian Bencana</div>
                        <div class="mt-2">
                            <span class="badge bg-danger me-1">{{ $kejadianAktif }} aktif</span>
                            <span class="badge bg-success">{{ $kejadianSelesai }} selesai</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="h2 fw-bold text-success mb-2">Rp {{ number_format($totalDonasiValue/1000000, 1, ',', '.') }}jt</div>
                        <div class="text-muted">Total Donasi</div>
                        <div class="mt-2">
                            <span class="badge bg-secondary">{{ $totalDonasiCount }} transaksi</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="h2 fw-bold text-warning mb-2">{{ $logistikStokTotal }}</div>
                        <div class="text-muted">Stok Logistik</div>
                        <div class="mt-2">
                            <span class="badge bg-warning">{{ $logistikStokKritis }} kritis</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="h2 fw-bold text-info mb-2">{{ $totalWarga }}</div>
                        <div class="text-muted">Warga Terdata</div>
                        <div class="mt-2">
                            <span class="badge bg-info">{{ $totalPosko }} posko</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== DUA TABEL UTAMA ========== -->
        <div class="row">
            <!-- KEJADIAN BENCANA AKTIF -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                            Kejadian Bencana Aktif
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $kejadianAktifList = $kejadianTerbaru->where('status_kejadian', 'Dilaporkan');
                        @endphp
                        
                        @if($kejadianAktifList->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">Jenis</th>
                                        <th>Tanggal</th>
                                        <th class="pe-3">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kejadianAktifList->take(4) as $kejadian)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-medium">{{ $kejadian->jenis_bencana }}</div>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($kejadian->tanggal)->format('d/m') }}
                                        </td>
                                        <td class="pe-3">
                                            <small>{{ Str::limit($kejadian->lokasi_text, 15) }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle text-muted fs-1 mb-3"></i>
                            <p class="text-muted">Tidak ada kejadian aktif</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- DONASI TERBARU -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-cash-coin text-success me-2"></i>
                            Donasi Terbaru
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @if($donasiTerbesar->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">Donatur</th>
                                        <th>Jenis</th>
                                        <th class="pe-3">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($donasiTerbesar->take(4) as $donasi)
                                    <tr>
                                        <td class="ps-3">
                                            <small>{{ Str::limit($donasi->donatur_nama, 15) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $donasi->jenis }}</span>
                                        </td>
                                        <td class="pe-3">
                                            <div class="fw-bold text-success">
                                                Rp {{ number_format($donasi->nilai/1000000, 1, ',', '.') }}jt
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="bi bi-cash text-muted fs-1 mb-3"></i>
                            <p class="text-muted">Belum ada data donasi</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== LOGISTIK STOK RENDAH ========== -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-exclamation-circle text-warning me-2"></i>
                            Stok Logistik Menipis
                            <span class="badge bg-warning ms-2">{{ $logistikStokKritis }}</span>
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $logistikKritis = $logistikPenting->where('stok', '<', 10)->where('stok', '>', 0);
                        @endphp
                        
                        @if($logistikKritis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">Barang</th>
                                        <th>Stok</th>
                                        <th>Satuan</th>
                                        <th class="pe-3">Sumber</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logistikKritis->take(5) as $logistik)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-medium">{{ $logistik->nama_barang }}</div>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-danger">{{ $logistik->stok }}</span>
                                        </td>
                                        <td>
                                            <small>{{ $logistik->satuan }}</small>
                                        </td>
                                        <td class="pe-3">
                                            <small>{{ Str::limit($logistik->sumber, 12) }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle text-muted fs-1 mb-3"></i>
                            <p class="text-muted">Semua stok logistik aman</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== STATISTIK SINGKAT ========== -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Status Kejadian</h6>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge bg-danger me-2"></span>
                                <span>Aktif</span>
                            </div>
                            <span class="fw-bold">{{ $kejadianAktif }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge bg-warning me-2"></span>
                                <span>Verifikasi</span>
                            </div>
                            <span class="fw-bold">{{ $kejadianVerifikasi }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-success me-2"></span>
                                <span>Selesai</span>
                            </div>
                            <span class="fw-bold">{{ $kejadianSelesai }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Distribusi Logistik</h6>
                        <div class="text-center py-3">
                            <div class="display-6 fw-bold text-primary mb-2">{{ $distribusiHariIni ?? 0 }}</div>
                            <p class="text-muted mb-0">Item hari ini</p>
                        </div>
                        <div class="mt-3 text-center">
                            <small class="text-muted">Total: {{ $totalDistribusi }} item</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Jenis Bencana</h6>
                        @foreach($jenisBencanaStats as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ Str::limit($item->jenis_bencana, 12) }}</span>
                            <span class="fw-bold">{{ $item->total }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .card {
        border-radius: 0.5rem;
        transition: transform 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .table th {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d;
        background-color: #f8f9fa;
        padding: 0.75rem 0.5rem;
    }
    
    .table td {
        font-size: 0.9rem;
        padding: 0.75rem 0.5rem;
        vertical-align: middle;
    }
    
    .h2 {
        font-size: 2rem;
        margin-bottom: 0.25rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    .display-6 {
        font-size: 2.5rem;
        font-weight: bold;
    }
</style>
@endsection