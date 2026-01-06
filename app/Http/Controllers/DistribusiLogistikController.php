<?php
// app/Http/Controllers/DistribusiLogistikController.php

namespace App\Http\Controllers;

use App\Models\DistribusiLogistik;
use App\Models\LogistikBencana;
use App\Models\PoskoBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DistribusiLogistikController extends Controller
{
    // Index - Menampilkan semua distribusi
    public function index(Request $request)
    {
        $query = DistribusiLogistik::with(['logistik', 'posko']);

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('penerima', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('logistik', function($q) use ($search) {
                      $q->where('nama_barang', 'like', "%{$search}%");
                  })
                  ->orWhereHas('posko', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter tanggal
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter logistik
        if ($request->has('logistik_id') && $request->logistik_id != '') {
            $query->where('logistik_id', $request->logistik_id);
        }

        // Filter posko
        if ($request->has('posko_id') && $request->posko_id != '') {
            $query->where('posko_id', $request->posko_id);
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'terlama':
                $query->orderBy('tanggal', 'asc')->orderBy('created_at', 'asc');
                break;
            case 'jumlah_terbanyak':
                $query->orderBy('jumlah', 'desc');
                break;
            default:
                $query->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');
        }

        $data = $query->paginate(5);
        
        $listLogistik = LogistikBencana::where('stok', '>', 0)
                         ->orderBy('nama_barang')
                         ->get();
        
        $listPosko = PoskoBencana::orderBy('nama')->get();

        return view('distribusi.index', compact('data', 'listLogistik', 'listPosko'));
    }

    // Create - Form tambah distribusi
    public function create()
    {
        $logistik = LogistikBencana::where('stok', '>', 0)
                     ->orderBy('nama_barang')
                     ->get();
        
        $posko = PoskoBencana::orderBy('nama')->get();
        
        return view('distribusi.create', compact('logistik', 'posko'));
    }

    // Store - Simpan distribusi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'logistik_id' => 'required|exists:logistik_bencana,logistik_id',
            'posko_id' => 'required|exists:posko_bencana,posko_id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'penerima' => 'required|string|max:100',
            'bukti_distribusi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan' => 'nullable|string|max:500'
        ]);

        // Cek stok logistik
        $logistik = LogistikBencana::find($request->logistik_id);
        if ($logistik->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok logistik tidak mencukupi. Stok tersedia: ' . $logistik->stok])->withInput();
        }

        // Upload bukti distribusi jika ada
        if ($request->hasFile('bukti_distribusi')) {
            $path = $request->file('bukti_distribusi')->store('distribusi', 'public');
            $validated['bukti_distribusi'] = $path;
        }

        // Simpan distribusi
        $distribusi = DistribusiLogistik::create($validated);

        // Update stok logistik
        $logistik->stok -= $request->jumlah;
        $logistik->save();

        return redirect()->route('distribusi.index')
                         ->with('success', 'Distribusi logistik berhasil ditambahkan!');
    }

    // Show - Tampilkan detail distribusi
    public function show($id)
    {
        $distribusi = DistribusiLogistik::with(['logistik', 'posko'])->findOrFail($id);
        return view('distribusi.show', compact('distribusi'));
    }

    // Edit - Form edit distribusi
    public function edit($id)
    {
        $distribusi = DistribusiLogistik::findOrFail($id);
        $logistik = LogistikBencana::orderBy('nama_barang')->get();
        $posko = PoskoBencana::orderBy('nama')->get();
        
        return view('distribusi.edit', compact('distribusi', 'logistik', 'posko'));
    }

    // Update - Update distribusi
    public function update(Request $request, $id)
    {
        $distribusi = DistribusiLogistik::findOrFail($id);

        $validated = $request->validate([
            'logistik_id' => 'required|exists:logistik_bencana,logistik_id',
            'posko_id' => 'required|exists:posko_bencana,posko_id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'penerima' => 'required|string|max:100',
            'bukti_distribusi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan' => 'nullable|string|max:500'
        ]);

        // Hitung selisih jumlah
        $jumlahLama = $distribusi->jumlah;
        $jumlahBaru = $request->jumlah;
        $selisih = $jumlahBaru - $jumlahLama;

        // Cek stok jika jumlah bertambah
        if ($selisih > 0) {
            $logistik = LogistikBencana::find($request->logistik_id);
            if ($logistik->stok < $selisih) {
                return back()->withErrors(['jumlah' => 'Stok logistik tidak mencukupi. Stok tersedia: ' . $logistik->stok])->withInput();
            }
        }

        // Upload bukti distribusi baru jika ada
        if ($request->hasFile('bukti_distribusi')) {
            // Hapus bukti lama jika ada
            if ($distribusi->bukti_distribusi) {
                Storage::disk('public')->delete($distribusi->bukti_distribusi);
            }
            
            $path = $request->file('bukti_distribusi')->store('distribusi', 'public');
            $validated['bukti_distribusi'] = $path;
        }

        // Update distribusi
        $distribusi->update($validated);

        // Update stok logistik
        if ($selisih != 0) {
            $logistik = LogistikBencana::find($request->logistik_id);
            $logistik->stok -= $selisih;
            $logistik->save();
        }

        return redirect()->route('distribusi.index')
                         ->with('success', 'Distribusi logistik berhasil diperbarui!');
    }

    // Destroy - Hapus distribusi
    public function destroy($id)
    {
        $distribusi = DistribusiLogistik::findOrFail($id);
        
        // Kembalikan stok logistik
        $logistik = $distribusi->logistik;
        $logistik->stok += $distribusi->jumlah;
        $logistik->save();

        // Hapus bukti distribusi jika ada
        if ($distribusi->bukti_distribusi) {
            Storage::disk('public')->delete($distribusi->bukti_distribusi);
        }

        $distribusi->delete();

        return redirect()->route('distribusi.index')
                         ->with('success', 'Distribusi logistik berhasil dihapus!');
    }
}