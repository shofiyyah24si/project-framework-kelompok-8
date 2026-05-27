<?php
// app/Http/Controllers/DonasiBencanaController.php

namespace App\Http\Controllers;

use App\Models\DonasiBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DonasiBencanaController extends Controller
{
    public function index(Request $request)
    {
        $query = DonasiBencana::with('kejadian');

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donatur_nama', 'like', "%$search%")
                  ->orWhere('jenis', 'like', "%$search%")
                  ->orWhere('metode_pembayaran', 'like', "%$search%");
            });
        }

        // HAPUS FILTER STATUS
        // if ($request->status) {
        //     $query->where('status', $request->status);
        // }

        // Filter by kejadian
        if ($request->kejadian_id) {
            $query->where('kejadian_id', $request->kejadian_id);
        }

        // Filter jenis
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $data = $query->latest()->paginate(5)->withQueryString();

        // ========== STATISTIK GLOBAL (SINKRON DASHBOARD) ==========
        $totalDonasi      = DonasiBencana::sum('nilai') ?? 0;
        $totalDonasiCount = DonasiBencana::count();

        $listKejadian = KejadianBencana::select('kejadian_id', 'jenis_bencana')->get();
        
        // List untuk dropdown jenis
        $jenisList = ['Uang Tunai', 'Transfer Bank', 'E-Wallet', 'Barang', 'Makanan', 'Obat-obatan', 'Pakaian', 'Lainnya'];

        return view('donasi.index', compact(
            'data',
            'totalDonasi',
            'totalDonasiCount',
            'listKejadian',
            'jenisList'
        ));
    }
    
    public function create()
    {
        $kejadianList = KejadianBencana::all();
        return view('donasi.create', compact('kejadianList'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'kejadian_id' => 'required|exists:kejadian_bencana,kejadian_id',
                'donatur_nama' => 'required|string|max:255',
                'jenis' => 'required|string|max:100',
                'nilai' => 'required|numeric|min:0',
                'bukti_donasi' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
                'keterangan' => 'nullable|string',
                'tanggal_donasi' => 'required|date',
                'metode_pembayaran' => 'nullable|string|max:100',
                // HAPUS VALIDASI STATUS
                // 'status' => 'required|in:pending,diterima,ditolak'
            ]);

            if ($request->hasFile('bukti_donasi')) {
                $validated['bukti_donasi'] = $request->file('bukti_donasi')->store('donasi/bukti', 'public');
            }

            DonasiBencana::create($validated);

            DB::commit();

            return redirect()->route('donasi.index')
                ->with('success', 'Data donasi berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Donasi Store Error: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Gagal menyimpan data donasi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $donasi = DonasiBencana::findOrFail($id);
        $kejadianList = KejadianBencana::all();
        
        return view('donasi.edit', compact('donasi', 'kejadianList'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $donasi = DonasiBencana::findOrFail($id);

            $validated = $request->validate([
                'kejadian_id' => 'required|exists:kejadian_bencana,kejadian_id',
                'donatur_nama' => 'required|string|max:255',
                'jenis' => 'required|string|max:100',
                'nilai' => 'required|numeric|min:0',
                'bukti_donasi' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
                'keterangan' => 'nullable|string',
                'tanggal_donasi' => 'required|date',
                'metode_pembayaran' => 'nullable|string|max:100',
                // HAPUS VALIDASI STATUS
                // 'status' => 'required|in:pending,diterima,ditolak'
            ]);

            if ($request->hasFile('bukti_donasi')) {
                // Hapus bukti lama
                if ($donasi->bukti_donasi && Storage::disk('public')->exists($donasi->bukti_donasi)) {
                    Storage::disk('public')->delete($donasi->bukti_donasi);
                }
                $validated['bukti_donasi'] = $request->file('bukti_donasi')->store('donasi/bukti', 'public');
            } else {
                $validated['bukti_donasi'] = $donasi->bukti_donasi;
            }

            $donasi->update($validated);

            DB::commit();

            return redirect()->route('donasi.index')
                ->with('success', 'Data donasi berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Donasi Update Error: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Gagal mengupdate data donasi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $donasi = DonasiBencana::findOrFail($id);

            // Hapus file bukti donasi
            if ($donasi->bukti_donasi && Storage::disk('public')->exists($donasi->bukti_donasi)) {
                Storage::disk('public')->delete($donasi->bukti_donasi);
            }

            $donasi->delete();

            DB::commit();

            return redirect()->route('donasi.index')
                ->with('success', 'Data donasi berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Donasi Delete Error: ' . $e->getMessage());
            
            return back()->with('error', 'Gagal menghapus data donasi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $donasi = DonasiBencana::with('kejadian')->findOrFail($id);
        return view('donasi.show', compact('donasi'));
    }
}