<?php
// app/Http/Controllers/LogistikBencanaController.php

namespace App\Http\Controllers;

use App\Models\LogistikBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;

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
                  ->orWhere('sumber', 'like', "%$search%");
            });
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
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $data = $query->paginate(10)->withQueryString();
        $totalStok = LogistikBencana::sum('stok');
        $listKejadian = KejadianBencana::select('kejadian_id', 'jenis_bencana')->get();
        
        // ✅ HAPUS STATUS LIST DAN STATS
        return view('logistik.index', compact(
            'data', 
            'totalStok', 
            'listKejadian'
        ));
    }

    public function show($id)
    {
        $logistik = LogistikBencana::with('kejadian')->findOrFail($id);
        
        // Tambahkan alias untuk field di view
        $logistik->kuantitas = $logistik->stok;
        $logistik->sumber_logistik = $logistik->sumber;
        
        return view('logistik.show', compact('logistik'));
    }

    // 🚫 HAPUS SEMUA METHOD CRUD
    public function create()
    {
        abort(404, 'Fitur tidak tersedia');
    }

    public function store(Request $request)
    {
        abort(404, 'Fitur tidak tersedia');
    }

    public function edit($id)
    {
        abort(404, 'Fitur tidak tersedia');
    }

    public function update(Request $request, $id)
    {
        abort(404, 'Fitur tidak tersedia');
    }

    public function destroy($id)
    {
        abort(404, 'Fitur tidak tersedia');
    }

    // 🚫 HAPUS METHOD reduceStock
}