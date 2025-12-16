<?php
// app/Http/Controllers/LogistikBencanaController.php

namespace App\Http\Controllers;

use App\Models\LogistikBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogistikBencanaController extends Controller
{
    public function index(Request $request)
    {
        $query = LogistikBencana::with('kejadian');

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%$search%")
                  ->orWhere('sumber', 'like', "%$search%")
                  ->orWhere('satuan', 'like', "%$search%");
            });
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by kejadian
        if ($request->kejadian_id) {
            $query->where('kejadian_id', $request->kejadian_id);
        }

        // ✅ TAMBAHKAN SORTING
        if ($request->sort) {
            switch ($request->sort) {
                case 'stok_terbanyak':
                    $query->orderByDesc('stok');
                    break;
                case 'stok_terendah':
                    $query->orderBy('stok');
                    break;
                case 'kadaluarsa_terdekat':
                    $query->orderBy('tanggal_kadaluarsa');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $data = $query->paginate(10)->withQueryString();
        $totalStok = LogistikBencana::sum('stok');
        $listKejadian = KejadianBencana::select('kejadian_id', 'jenis_bencana')->get();
        $statusList = ['tersedia', 'dipinjam', 'habis', 'kadaluarsa'];
        
        // ✅ TAMBAHKAN STATS
        $stats = [
            'tersedia' => LogistikBencana::where('status', 'tersedia')->count(),
            'dipinjam' => LogistikBencana::where('status', 'dipinjam')->count(),
            'habis' => LogistikBencana::where('status', 'habis')->count(),
            'kadaluarsa' => LogistikBencana::where('status', 'kadaluarsa')->count(),
        ];

        // ✅ PASS STATS KE VIEW
        return view('logistik.index', compact(
            'data', 
            'totalStok', 
            'listKejadian', 
            'statusList',
            'stats' // ✅ INI YANG BARU
        ));
    }

    public function create()
    {
        $kejadianList = KejadianBencana::all();
        return view('logistik.create', compact('kejadianList'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'kejadian_id' => 'required|exists:kejadian_bencana,kejadian_id',
                'nama_barang' => 'required|string|max:255',
                'satuan' => 'required|string|max:50',
                'stok' => 'required|integer|min:0',
                'sumber' => 'required|string|max:255',
                'keterangan' => 'nullable|string',
                'tanggal_masuk' => 'required|date',
                'tanggal_kadaluarsa' => 'nullable|date',
                'status' => 'required|in:tersedia,dipinjam,habis,kadaluarsa'
            ]);

            LogistikBencana::create($validated);

            DB::commit();

            return redirect()->route('logistik.index')
                ->with('success', 'Data logistik berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Logistik Store Error: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Gagal menyimpan data logistik: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $logistik = LogistikBencana::findOrFail($id);
        $kejadianList = KejadianBencana::all();
        
        return view('logistik.edit', compact('logistik', 'kejadianList'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $logistik = LogistikBencana::findOrFail($id);

            $validated = $request->validate([
                'kejadian_id' => 'required|exists:kejadian_bencana,kejadian_id',
                'nama_barang' => 'required|string|max:255',
                'satuan' => 'required|string|max:50',
                'stok' => 'required|integer|min:0',
                'sumber' => 'required|string|max:255',
                'keterangan' => 'nullable|string',
                'tanggal_masuk' => 'required|date',
                'tanggal_kadaluarsa' => 'nullable|date',
                'status' => 'required|in:tersedia,dipinjam,habis,kadaluarsa'
            ]);

            $logistik->update($validated);

            DB::commit();

            return redirect()->route('logistik.index')
                ->with('success', 'Data logistik berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Logistik Update Error: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Gagal mengupdate data logistik: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $logistik = LogistikBencana::findOrFail($id);
            $logistik->delete();

            DB::commit();

            return redirect()->route('logistik.index')
                ->with('success', 'Data logistik berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Logistik Delete Error: ' . $e->getMessage());
            
            return back()->with('error', 'Gagal menghapus data logistik: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $logistik = LogistikBencana::with('kejadian')->findOrFail($id);
        return view('logistik.show', compact('logistik'));
    }

    // API untuk mengurangi stok
    public function reduceStock(Request $request, $id)
    {
        try {
            $logistik = LogistikBencana::findOrFail($id);
            
            $request->validate([
                'jumlah' => 'required|integer|min:1|max:' . $logistik->stok
            ]);

            $logistik->stok -= $request->jumlah;
            
            if ($logistik->stok == 0) {
                $logistik->status = 'habis';
            }
            
            $logistik->save();

            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil dikurangi',
                'sisa_stok' => $logistik->stok
            ]);

        } catch (\Exception $e) {
            Log::error('Reduce Stock Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengurangi stok'
            ], 500);
        }
    }
}