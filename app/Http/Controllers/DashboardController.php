<?php

namespace App\Http\Controllers;

use App\Models\KejadianBencana;
use App\Models\PoskoBencana;
use App\Models\DonasiBencana;
use App\Models\LogistikBencana;
use App\Models\DistribusiLogistik;
use App\Models\Warga;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ========== KEJADIAN BENCANA ==========
        $totalKejadian = KejadianBencana::count();
        $kejadianAktif = KejadianBencana::where('status_kejadian', 'Dilaporkan')->count();
        $kejadianVerifikasi = KejadianBencana::where('status_kejadian', 'Verifikasi')->count();
        $kejadianSelesai = KejadianBencana::where('status_kejadian', 'Selesai')->count();
        
        // Kejadian Terbaru (untuk tabel)
        $kejadianTerbaru = KejadianBencana::orderBy('tanggal', 'desc')
            ->take(5)
            ->get(['kejadian_id', 'jenis_bencana', 'tanggal', 'lokasi_text', 'dampak', 'status_kejadian']);
        
        // Statistik jenis bencana
        $jenisBencanaStats = KejadianBencana::select('jenis_bencana', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_bencana')
            ->orderByDesc('total')
            ->take(5)
            ->get();
        
        // ========== POSKO BENCANA ==========
        $totalPosko = PoskoBencana::count();
        $poskoList = PoskoBencana::with('kejadian')  // ← UBAH: 'kejadianBencana' menjadi 'kejadian'
            ->orderByDesc('created_at')
            ->take(3)
            ->get(['posko_id', 'nama', 'alamat', 'kontak', 'kejadian_id']);
        
        // ========== DONASI BENCANA ==========
        $totalDonasiValue = DonasiBencana::sum('nilai') ?? 0;
        $totalDonasiCount = DonasiBencana::count();
        
        // Donasi Terbesar (untuk tabel)
        $donasiTerbesar = DonasiBencana::with('kejadian')  // ← UBAH: 'kejadianBencana' menjadi 'kejadian'
            ->orderByDesc('nilai')
            ->take(5)
            ->get(['donasi_id', 'donatur_nama', 'jenis', 'nilai', 'kejadian_id']);
        
        // ========== LOGISTIK BENCANA ==========
        $totalLogistik = LogistikBencana::count();
        $logistikStokTotal = LogistikBencana::sum('stok') ?? 0;
        $logistikStokKosong = LogistikBencana::where('stok', 0)->count();
        $logistikStokAda = LogistikBencana::where('stok', '>', 0)->count();
        $logistikStokKritis = LogistikBencana::where('stok', '<', 10)
            ->where('stok', '>', 0)
            ->count();
        
        // Logistik Penting (untuk tabel)
        $logistikPenting = LogistikBencana::orderByDesc('stok')
            ->take(10)
            ->get(['logistik_id', 'nama_barang', 'satuan', 'stok', 'sumber']);
        
        // ========== DISTRIBUSI LOGISTIK ==========
        $totalDistribusi = DistribusiLogistik::sum('jumlah') ?? 0;
        $distribusiHariIni = DistribusiLogistik::whereDate('tanggal', Carbon::today())
            ->sum('jumlah') ?? 0;
        
        // ========== WARGA ==========
        $totalWarga = Warga::count();
        
        // Warga Terbaru (untuk tabel)
        $wargaTerbaru = Warga::orderByDesc('created_at')
            ->take(5)
            ->get(['warga_id', 'nama', 'jenis_kelamin', 'pekerjaan', 'telp']);

        return view('dashboard', compact(
            // Kejadian Bencana
            'totalKejadian',
            'kejadianAktif',
            'kejadianVerifikasi',
            'kejadianSelesai',
            'kejadianTerbaru',
            'jenisBencanaStats',
            
            // Posko Bencana
            'totalPosko',
            'poskoList',
            
            // Donasi Bencana
            'totalDonasiValue',
            'totalDonasiCount',
            'donasiTerbesar',
            
            // Logistik Bencana
            'totalLogistik',
            'logistikStokTotal',
            'logistikStokKosong',
            'logistikStokAda',
            'logistikStokKritis',
            'logistikPenting',
            
            // Distribusi Logistik
            'totalDistribusi',
            'distribusiHariIni',
            
            // Warga
            'totalWarga',
            'wargaTerbaru'
        ));
    }
}