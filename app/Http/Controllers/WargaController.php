<?php

namespace App\Http\Controllers;

use App\Models\KejadianBencana;
use App\Models\PoskoBencana;
use App\Models\DonasiBencana;
use App\Models\LogistikBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    /**
     * Menampilkan dashboard khusus untuk warga
     */
    public function dashboard()
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            return redirect()->route('admin.dashboard');
        }

        // Ambil data untuk dashboard warga
        $totalKejadian = KejadianBencana::where('status', 'aktif')->count();
        $totalPosko = PoskoBencana::where('status', 'aktif')->count();
        $totalDonasi = DonasiBencana::where('status', 'terkonfirmasi')->count();
        
        // Data kejadian terbaru (hanya 5 terbaru)
        $kejadianTerbaru = KejadianBencana::with('files')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Data posko terdekat (contoh sederhana)
        $poskoTerdekat = PoskoBencana::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('warga.dashboard', compact(
            'totalKejadian',
            'totalPosko',
            'totalDonasi',
            'kejadianTerbaru',
            'poskoTerdekat'
        ));
    }

    /**
     * Halaman profile warga
     */
    public function profile()
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $user = Auth::user();
        return view('warga.profile', compact('user'));
    }

    /**
     * Update profile warga
     */
    public function updateProfile(Request $request)
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('warga.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Menampilkan daftar kejadian bencana (READ ONLY untuk warga)
     */
    public function kejadian()
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $kejadian = KejadianBencana::with('files')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('warga.kejadian.index', compact('kejadian'));
    }

    /**
     * Menampilkan detail kejadian bencana (READ ONLY untuk warga)
     */
    public function showKejadian($id)
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $kejadian = KejadianBencana::with('files')->findOrFail($id);
        
        // Pastikan kejadian aktif atau warga bisa melihatnya
        if ($kejadian->status !== 'aktif') {
            abort(404, 'Kejadian tidak ditemukan atau tidak aktif.');
        }

        return view('warga.kejadian.show', compact('kejadian'));
    }

    /**
     * Menampilkan daftar posko (READ ONLY untuk warga)
     */
    public function posko()
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $posko = PoskoBencana::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('warga.posko.index', compact('posko'));
    }

    /**
     * Menampilkan detail posko (READ ONLY untuk warga)
     */
    public function showPosko($id)
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $posko = PoskoBencana::findOrFail($id);
        
        // Pastikan posko aktif
        if ($posko->status !== 'aktif') {
            abort(404, 'Posko tidak ditemukan atau tidak aktif.');
        }

        return view('warga.posko.show', compact('posko'));
    }

    /**
     * Menampilkan daftar donasi (READ ONLY untuk warga)
     */
    public function donasi()
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $donasi = DonasiBencana::where('status', 'terkonfirmasi')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('warga.donasi.index', compact('donasi'));
    }

    /**
     * Form untuk membuat donasi baru (warga bisa membuat donasi)
     */
    public function createDonasi()
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $kejadianAktif = KejadianBencana::where('status', 'aktif')->get();
        return view('warga.donasi.create', compact('kejadianAktif'));
    }

    /**
     * Menyimpan donasi baru
     */
    public function storeDonasi(Request $request)
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $validated = $request->validate([
            'kejadian_bencana_id' => 'required|exists:kejadian_bencana,id',
            'nama_donatur' => 'required|string|max:255',
            'jenis_donasi' => 'required|in:uang,barang',
            'jumlah' => 'required',
            'keterangan' => 'nullable|string',
            'bukti_donasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Tambahkan user_id dan status default
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'menunggu'; // Status awal menunggu konfirmasi admin

        // Upload bukti donasi jika ada
        if ($request->hasFile('bukti_donasi')) {
            $path = $request->file('bukti_donasi')->store('bukti_donasi', 'public');
            $validated['bukti_donasi'] = $path;
        }

        DonasiBencana::create($validated);

        return redirect()->route('warga.donasi')
            ->with('success', 'Donasi berhasil dikirim. Menunggu konfirmasi admin.');
    }

    /**
     * Menampilkan daftar logistik (READ ONLY untuk warga)
     */
    public function logistik()
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $logistik = LogistikBencana::with('kejadian')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('warga.logistik.index', compact('logistik'));
    }

    /**
     * Menampilkan detail logistik (READ ONLY untuk warga)
     */
    public function showLogistik($id)
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $logistik = LogistikBencana::with('kejadian')->findOrFail($id);
        return view('warga.logistik.show', compact('logistik'));
    }

    /**
     * Method untuk halaman 403 - Forbidden
     * Akan dipanggil ketika warga mencoba akses fitur admin
     */
    public function forbidden()
    {
        return view('errors.403', [
            'message' => 'Akses ditolak. Fitur ini hanya tersedia untuk administrator.'
        ]);
    }

    /**
     * Ubah password warga
     */
    public function changePassword(Request $request)
    {
        // Hanya warga yang bisa mengakses
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }

        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->route('warga.profile')
            ->with('success', 'Password berhasil diubah.');
    }
}