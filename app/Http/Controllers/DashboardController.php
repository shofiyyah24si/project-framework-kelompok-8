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
     * Tampilkan halaman dashboard (TANPA AUTH & ROLE).
     */
    public function index()
    {
        // ========== PERBAIKAN DI SINI ==========
        // HAPUS AUTH - KARENA TIDAK ADA LOGIN
        // $user = auth()->user(); // ← INI ERROR KARENA TIDAK ADA MODEL USER
        // $isAdmin = $user->role === 'admin';
        // $isWarga = $user->role === 'warga';
        
        // GANTI DENGAN:
        $user = null; // Kosongkan karena tidak ada user
        $isAdmin = false; // Set false karena tidak ada admin
        $isWarga = false; // Set false karena tidak ada warga
        
        // ATAU jika ingin tetap tampil seperti ada user:
        // $user = (object) [
        //     'name' => 'Guest',
        //     'role' => 'guest'
        // ];
        // $isAdmin = false;
        // $isWarga = false;
        // ========== PERBAIKAN SELESAI ==========

        // DATA YANG SAMA UNTUK SEMUA (tanpa filter status)
        $totalKejadian = KejadianBencana::count();
        $totalPosko    = PoskoBencana::count();
        $totalDonasiValue = DonasiBencana::sum('nilai');
        $totalDonasiCount = DonasiBencana::count();
        $totalLogistik = LogistikBencana::count();

        // Kejadian Terbaru
        $kejadianTerbaru = KejadianBencana::orderByDesc('created_at')
                            ->take(5)
                            ->get();

        // Statistik Donasi
        $donasiStats = [
            'pending' => DonasiBencana::count(),
            'diterima' => DonasiBencana::count(),
            'ditolak' => DonasiBencana::count(),
        ];

        // Statistik Logistik
        $logistikStats = [
            'tersedia' => LogistikBencana::count(),
            'dipinjam' => LogistikBencana::count(),
            'habis' => LogistikBencana::count(),
            'kadaluarsa' => LogistikBencana::count(),
        ];

        // Aktivitas Terbaru - tampilkan untuk semua
        $recentActivities = $this->getRecentActivities();

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
     * Get recent activities for today
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

            $latestDonasi = DonasiBencana::latest()->first();
            if ($latestDonasi) {
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