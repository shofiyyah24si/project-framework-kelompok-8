<?php

namespace App\Http\Controllers;

use App\Models\KejadianBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KejadianBencanaController extends Controller
{
    /**
     * Menampilkan semua data kejadian bencana
     */
    public function index()
    {
        $kejadian = KejadianBencana::latest()->paginate(10);
        return view('kejadian.index', compact('kejadian'));
    }

    /**
     * Form tambah data
     */
    public function create()
    {
        return view('kejadian.create');
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_bencana'   => 'required|string|max:100',
            'tanggal'         => 'required|date',
            'lokasi_text'     => 'required|string|max:255',
            'rt'              => 'nullable|string|max:10',
            'rw'              => 'nullable|string|max:10',
            'dampak'          => 'nullable|string|max:255',
            'status_kejadian' => 'required|string|max:100',
            'keterangan'      => 'nullable|string',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ Upload foto jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kejadian_foto', 'public');
        }

        KejadianBencana::create($validated);

        return redirect()
            ->route('kejadian-bencana.index')
            ->with('success', 'Data kejadian bencana berhasil ditambahkan!');
    }

    /**
     * Form edit data
     */
    public function edit(KejadianBencana $kejadian_bencana)
    {
        return view('kejadian.edit', ['kejadian' => $kejadian_bencana]);
    }

    /**
     * Update data kejadian
     */
    public function update(Request $request, KejadianBencana $kejadian_bencana)
    {
        $validated = $request->validate([
            'jenis_bencana'   => 'required|string|max:100',
            'tanggal'         => 'required|date',
            'lokasi_text'     => 'required|string|max:255',
            'rt'              => 'nullable|string|max:10',
            'rw'              => 'nullable|string|max:10',
            'dampak'          => 'nullable|string|max:255',
            'status_kejadian' => 'required|string|max:100',
            'keterangan'      => 'nullable|string',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ Hanya jika user upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($kejadian_bencana->foto && Storage::disk('public')->exists($kejadian_bencana->foto)) {
                Storage::disk('public')->delete($kejadian_bencana->foto);
            }

            // Simpan foto baru
            $validated['foto'] = $request->file('foto')->store('kejadian_foto', 'public');
        }

        // ✅ Update data
        $kejadian_bencana->update($validated);

        return redirect()
            ->route('kejadian-bencana.index')
            ->with('success', 'Data kejadian bencana berhasil diperbarui!');
    }

    /**
     * Hapus data kejadian
     */
    public function destroy(KejadianBencana $kejadian_bencana)
    {
        // ✅ Hapus foto dari storage jika ada
        if ($kejadian_bencana->foto && Storage::disk('public')->exists($kejadian_bencana->foto)) {
            Storage::disk('public')->delete($kejadian_bencana->foto);
        }

        $kejadian_bencana->delete();

        return redirect()
            ->route('kejadian-bencana.index')
            ->with('success', 'Data kejadian bencana berhasil dihapus!');
    }
}
