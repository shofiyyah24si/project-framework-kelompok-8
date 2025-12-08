<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil request
        $search = $request->search;
        $rt     = $request->rt;
        $rw     = $request->rw;

        // Query dasar
        $query = Warga::query();

        // === SEARCH ===
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nik', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%")
                  ->orWhere('no_hp', 'like', "%$search%");
            });
        }

        // === FILTER RT ===
        if (!empty($rt)) {
            $query->where('rt', $rt);
        }

        // === FILTER RW ===
        if (!empty($rw)) {
            $query->where('rw', $rw);
        }

        // === PAGINATION ===
        $data = $query->latest()->paginate(3)->withQueryString();

        return view('warga.index', compact('data', 'search', 'rt', 'rw'));
    }

    public function create()
    {
        return view('warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required',
            'nik'    => 'required|unique:warga,nik',
            'alamat' => 'required',
        ]);

        Warga::create($validated + [
            'rt'    => $request->rt,
            'rw'    => $request->rw,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Warga::findOrFail($id);
        return view('warga.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Warga::findOrFail($id);

        $validated = $request->validate([
            'nama'   => 'required',
            'nik'    => 'required|unique:warga,nik,' . $id . ',warga_id',
            'alamat' => 'required',
        ]);

        $data->update($validated + [
            'rt'    => $request->rt,
            'rw'    => $request->rw,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Warga::destroy($id);
        return back()->with('success', 'Data warga berhasil dihapus.');
    }
}
