<?php

namespace App\Http\Controllers;

use App\Models\Relawan;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    public function index()
    {
        $relawan = Relawan::latest()->paginate(10);
        return view('relawan.index', compact('relawan'));
    }

    public function create()
    {
        return view('relawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'keahlian' => 'nullable|string|max:100',
        ]);

        Relawan::create($request->all());

        return redirect()->route('relawan.index')->with('success', 'Data relawan berhasil ditambahkan.');
    }

    public function edit(Relawan $relawan)
    {
        return view('relawan.edit', compact('relawan'));
    }

    public function update(Request $request, Relawan $relawan)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'keahlian' => 'nullable|string|max:100',
        ]);

        $relawan->update($request->all());

        return redirect()->route('relawan.index')->with('success', 'Data relawan berhasil diperbarui.');
    }

    public function destroy(Relawan $relawan)
    {
        $relawan->delete();
        return redirect()->route('relawan.index')->with('success', 'Data relawan berhasil dihapus.');
    }
}
