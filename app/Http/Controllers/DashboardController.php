<?php

namespace App\Http\Controllers;

use App\Models\KejadianBencana;
use App\Models\PoskoBencana;
use App\Models\DonasiBencana;
use App\Models\LogistikBencana;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard (SAMA untuk admin & warga).
     */
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';
        $isWarga = $user->role === 'warga';

        // DATA YANG SAMA UNTUK ADMIN DAN WARGA (hanya data aktif/diterima)
        
        // Total Data Aktif/Diterima
        $totalKejadian = KejadianBencana::where('status', 'aktif')->count();
        $totalPosko    = PoskoBencana::where('status', 'aktif')->count();
        
        // Total Donasi Diterima
        $totalDonasiValue = DonasiBencana::where('status', 'diterima')->sum('nilai');
        $totalDonasiCount = DonasiBencana::where('status', 'diterima')->count();
        
        // Total Logistik Tersedia
        $totalLogistik = LogistikBencana::where('status', 'tersedia')->count();

        // Kejadian Terbaru (Aktif)
        $kejadianTerbaru = KejadianBencana::where('status', 'aktif')
                            ->orderByDesc('created_at')
                            ->take(5)
                            ->get();

        // Statistik Donasi (diterima saja untuk ditampilkan)
        $donasiStats = [
            'pending' => DonasiBencana::where('status', 'pending')->count(),
            'diterima' => DonasiBencana::where('status', 'diterima')->count(),
            'ditolak' => DonasiBencana::where('status', 'ditolak')->count(),
        ];

        // Statistik Logistik (hanya yang tersedia untuk warga)
        $logistikStats = [
            'tersedia' => LogistikBencana::where('status', 'tersedia')->count(),
            'dipinjam' => LogistikBencana::where('status', 'dipinjam')->count(),
            'habis' => LogistikBencana::where('status', 'habis')->count(),
            'kadaluarsa' => LogistikBencana::where('status', 'kadaluarsa')->count(),
        ];

        // Aktivitas Terbaru (Hari Ini) - hanya untuk admin di view
        $recentActivities = $isAdmin ? $this->getRecentActivities() : [];

        return view('dashboard', compact(
            'user',
            'isAdmin',
            'isWarga',
            'totalKejadian',
            'totalPosko',
            'totalDonasiValue',
            'totalDonasiCount',
            'totalLogistik',
            'kejadianTerbaru',
            'donasiStats',
            'logistikStats',
            'recentActivities'
        ));
    }

    /**
     * Get recent activities for today (hanya untuk admin)
     */
    private function getRecentActivities()
    {
        $today = Carbon::today();
        $activities = [];

        // Kejadian hari ini
        $todayKejadian = KejadianBencana::whereDate('created_at', $today)->count();
        if ($todayKejadian > 0) {
            $activities[] = [
                'title' => 'Kejadian Baru',
                'description' => $todayKejadian . ' kejadian bencana ditambahkan hari ini',
                'icon' => 'exclamation-triangle',
                'color' => 'warning',
                'time' => 'Hari ini',
                'link' => route('kejadian.index')
            ];
        }

        // Donasi hari ini
        $todayDonasi = DonasiBencana::whereDate('created_at', $today)->count();
        if ($todayDonasi > 0) {
            $activities[] = [
                'title' => 'Donasi Masuk',
                'description' => $todayDonasi . ' donasi baru diterima hari ini',
                'icon' => 'cash-coin',
                'color' => 'info',
                'time' => 'Hari ini',
                'link' => route('donasi.index')
            ];
        }

        // Logistik hari ini
        $todayLogistik = LogistikBencana::whereDate('created_at', $today)->count();
        if ($todayLogistik > 0) {
            $activities[] = [
                'title' => 'Logistik Baru',
                'description' => $todayLogistik . ' item logistik ditambahkan hari ini',
                'icon' => 'box-seam',
                'color' => 'purple',
                'time' => 'Hari ini',
                'link' => route('logistik.index')
            ];
        }

        // Posko hari ini
        $todayPosko = PoskoBencana::whereDate('created_at', $today)->count();
        if ($todayPosko > 0) {
            $activities[] = [
                'title' => 'Posko Baru',
                'description' => $todayPosko . ' posko darurat ditambahkan hari ini',
                'icon' => 'house',
                'color' => 'success',
                'time' => 'Hari ini',
                'link' => route('posko.index')
            ];
        }

        // Jika tidak ada aktivitas hari ini, tampilkan aktivitas terbaru
        if (empty($activities)) {
            $latestKejadian = KejadianBencana::latest()->first();
            if ($latestKejadian) {
                // PERBAIKAN: Gunakan ID yang benar
                $kejadianId = $latestKejadian->id ?? $latestKejadian->kejadian_id ?? null;
                
                $activities[] = [
                    'title' => 'Kejadian Terakhir',
                    'description' => $latestKejadian->nama_bencana . ' di ' . $latestKejadian->lokasi,
                    'icon' => 'exclamation-triangle',
                    'color' => 'warning',
                    'time' => $latestKejadian->created_at->diffForHumans(),
                    'link' => $kejadianId ? route('kejadian.show', $kejadianId) : null
                ];
            }

            $latestDonasi = DonasiBencana::where('status', 'diterima')->latest()->first();
            if ($latestDonasi) {
                // PERBAIKAN: Gunakan ID yang benar
                $donasiId = $latestDonasi->id ?? $latestDonasi->donasi_id ?? null;
                
                $activities[] = [
                    'title' => 'Donasi Terakhir',
                    'description' => 'Rp ' . number_format($latestDonasi->nilai ?? 0, 0, ',', '.') . ' dari ' . ($latestDonasi->nama_donatur ?? 'Anonim'),
                    'icon' => 'cash-coin',
                    'color' => 'info',
                    'time' => $latestDonasi->created_at->diffForHumans(),
                    'link' => $donasiId ? route('donasi.show', $donasiId) : null
                ];
            }
        }

        // Limit to 4 activities
        return array_slice($activities, 0, 4);
    }

    // Method lain tetap sama
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}