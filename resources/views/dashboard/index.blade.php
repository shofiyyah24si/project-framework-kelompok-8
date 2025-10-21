@extends('layouts.kaiadmin')

@section('page_title', 'Dashboard - Kebencanaan & Tanggap Darurat')

@section('content')
<div class="page-inner mt-4">

    <!-- Judul Utama (Tengah dan Profesional) -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary mb-2" style="font-size: 2rem;">
            Sistem Kebencanaan & Tanggap Darurat
        </h1>
        <p class="text-muted mb-0" style="font-size: 1rem;">
            Sistem profesional untuk pemantauan kejadian bencana dan relawan secara real-time
        </p>
        <hr class="mx-auto mt-3" style="width: 250px; border-top: 3px solid #007bff;">
    </div>

    <!-- Banner Selamat Datang -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(90deg, #007bff, #00c6ff); color: white;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Selamat Datang di Sistem Kebencanaan & Tanggap Darurat</h4>
                <p class="mb-0">Pantau dan kelola data kejadian bencana serta relawan dengan cepat dan akurat.</p>
            </div>
            <i class="fas fa-shield-alt fa-3x opacity-75"></i>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card card-stats shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-big text-center text-primary me-3">
                        <i class="fas fa-fire fa-3x"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Kejadian Bencana</h5>
                        <h2 class="fw-bold text-primary mb-0">{{ $jumlahKejadian }}</h2>
                        <p class="text-muted mb-0">Total kejadian yang tercatat</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card card-stats shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-big text-center text-success me-3">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Relawan Terdaftar</h5>
                        <h2 class="fw-bold text-success mb-0">{{ $jumlahRelawan }}</h2>
                        <p class="text-muted mb-0">Total relawan aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Aktivitas -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold d-flex align-items-center justify-content-between">
            <div>
                <i class="fas fa-chart-line me-2 text-primary"></i> Grafik Aktivitas Kebencanaan
            </div>
            <span class="badge bg-primary text-white shadow-sm px-3 py-2">
                <i class="fas fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </span>
        </div>
        <div class="card-body">
            <canvas id="chartBencana" height="100"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartBencana').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
            datasets: [{
                label: 'Jumlah Kejadian Bencana',
                data: [5, 3, 6, 2, 4, 7],
                backgroundColor: 'rgba(0, 123, 255, 0.6)',
                borderColor: '#007bff',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush
@endsection
