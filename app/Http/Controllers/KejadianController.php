<?php

namespace App\Http\Controllers;


use App\Models\Kejadian;
use Illuminate\Http\Request;

class KejadianController extends Controller
{
    public function index()
    {
        $kejadian = Kejadian::latest()->paginate(10);
        return view('kejadian.index', compact('kejadian'));
    }

    // Form tambah data
    public function create()
    {
        return view('kejadian.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_bencana' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'lokasi_text' => 'required|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'dampak' => 'nullable|string|max:255',
            'status_kejadian' => 'required|in:aktif,selesai,dalam_penanganan',
            'keterangan' => 'nullable|string',
            'media' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf',
        ]);

        if ($request->hasFile('media')) {
            $validated['media'] = $request->file('media')->store('kejadian_bencana', 'public');
        }

        Kejadian::create($validated);

        return redirect()->route('kejadian.index')
                         ->with('success', 'Kejadian bencana berhasil ditambahkan.');
    }

    // Form edit data
    public function edit(Kejadian $kejadian)
    {
        return view('kejadian.edit', compact('kejadian'));
    }

    // Update data
    public function update(Request $request, Kejadian $kejadian)
    {
        $validated = $request->validate([
            'jenis_bencana' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'lokasi_text' => 'required|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'dampak' => 'nullable|string|max:255',
            'status_kejadian' => 'required|in:aktif,selesai,dalam_penanganan',
            'keterangan' => 'nullable|string',
            'media' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf',
        ]);

        if ($request->hasFile('media')) {
            $validated['media'] = $request->file('media')->store('kejadian_bencana', 'public');
        }

        $kejadian->update($validated);

        return redirect()->route('kejadian.index')
                         ->with('success', 'Data kejadian berhasil diperbarui.');
    }

    // Hapus data
    public function destroy(Kejadian $kejadian)
    {
        $kejadian->delete();
        return redirect()->route('kejadian.index')
                         ->with('success', 'Data kejadian berhasil dihapus.');
    }
}
