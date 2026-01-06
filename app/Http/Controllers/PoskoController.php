<?php

namespace App\Http\Controllers;

use App\Models\PoskoBencana;
use App\Models\KejadianBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PoskoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX (Search + Filter + Pagination)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = PoskoBencana::with('kejadian');

        // =====================
        // SEARCH
        // =====================
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%")
                  ->orWhere('kontak', 'like', "%$search%")
                  ->orWhere('penanggung_jawab', 'like', "%$search%");
            });
        }

        // =====================
        // FILTER KEJADIAN
        // =====================
        if ($request->kejadian_id) {
            $query->where('kejadian_id', $request->kejadian_id);
        }

        // =====================
        // FILTER LOKASI (berdasarkan alamat)
        // =====================
        if ($request->lokasi) {
            $query->where('alamat', 'like', "%{$request->lokasi}%");
        }

        // PAGINATION
        $data = $query->latest()->paginate(10)->withQueryString();

        // DROPDOWN
        $listKejadian = KejadianBencana::select('kejadian_id', 'jenis_bencana')->get();

        return view('posko.index', compact('data', 'listKejadian'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $kejadian = KejadianBencana::all();
        return view('posko.create', compact('kejadian'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kejadian_id'      => 'required|exists:kejadian_bencana,kejadian_id',
            'nama'             => 'required',
            'alamat'           => 'required',
            'kontak'           => 'required',
            'penanggung_jawab' => 'required',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('posko_bencana', 'public');
        }

        PoskoBencana::create($validated);

        return redirect()->route('posko.index')->with('success', 'Data posko berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW (Detail)
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $data = PoskoBencana::with('kejadian')->findOrFail($id);
        return view('posko.show', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $data = PoskoBencana::findOrFail($id);
        $kejadian = KejadianBencana::all();
        return view('posko.edit', compact('data', 'kejadian'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $data = PoskoBencana::findOrFail($id);

        $validated = $request->validate([
            'kejadian_id'      => 'required|exists:kejadian_bencana,kejadian_id',
            'nama'             => 'required',
            'alamat'           => 'required',
            'kontak'           => 'required',
            'penanggung_jawab' => 'required',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($data->foto) {
                Storage::disk('public')->delete($data->foto);
            }
            $validated['foto'] = $request->file('foto')->store('posko_bencana', 'public');
        }

        $data->update($validated);

        return redirect()->route('posko.index')->with('success', 'Data posko berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $data = PoskoBencana::findOrFail($id);

        if ($data->foto) {
            Storage::disk('public')->delete($data->foto);
        }

        $data->delete();

        return back()->with('success', 'Data posko berhasil dihapus.');
    }
}