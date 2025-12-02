<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KejadianBencana;
use App\Models\KejadianFile;
use Illuminate\Support\Facades\Storage;

class KejadianController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX (Search + Filter + Pagination)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = KejadianBencana::with('files');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis_bencana', 'like', "%$search%")
                    ->orWhere('lokasi_text', 'like', "%$search%")
                    ->orWhere('dampak', 'like', "%$search%")
                    ->orWhere('status_kejadian', 'like', "%$search%")
                    ->orWhere('keterangan', 'like', "%$search%");
            });
        }

        if ($request->rt)   $query->where('rt', $request->rt);
        if ($request->rw)   $query->where('rw', $request->rw);
        if ($request->status) $query->where('status_kejadian', $request->status);

        $data = $query->latest()->paginate(5)->withQueryString();

        $listRT     = KejadianBencana::select('rt')->distinct()->pluck('rt');
        $listRW     = KejadianBencana::select('rw')->distinct()->pluck('rw');
        $listStatus = ['Baru', 'Proses', 'Selesai'];

        return view('kejadian.index', compact('data', 'listRT', 'listRW', 'listStatus'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('kejadian.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (Foto Utama + Multiple Files)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_bencana'    => 'required',
            'tanggal'          => 'required|date',
            'lokasi_text'      => 'required',
            'rt'               => 'required',
            'rw'               => 'required',
            'dampak'           => 'required',
            'status_kejadian'  => 'required',
            'keterangan'       => 'nullable',

            // Foto utama
            'foto'             => 'nullable|image|max:4096',

            // Multiple upload
            'files.*'          => 'nullable|mimes:jpg,jpeg,png,mp4,avi,pdf,doc,docx|max:12288'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kejadian/foto_utama', 'public');
        }

        $kejadian = KejadianBencana::create($validated);

        // Upload dokumentasi
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('kejadian/dokumentasi', $filename, 'public');

                KejadianFile::create([
                    'kejadian_id' => $kejadian->kejadian_id,
                    'nama_file'   => $filename,
                    'tipe'        => $file->extension()
                ]);
            }
        }

        return redirect()->route('kejadian.index')->with('success', 'Data kejadian berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $data = KejadianBencana::with('files')->findOrFail($id);
        return view('kejadian.edit', compact('data'));
    }

    public function show($id)
    {
        $data = KejadianBencana::with('files')->findOrFail($id);

        return view('kejadian.show', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE (Foto Utama + Multiple Files)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $kejadian = KejadianBencana::findOrFail($id);

        $validated = $request->validate([
            'jenis_bencana'    => 'required',
            'tanggal'          => 'required|date',
            'lokasi_text'      => 'required',
            'rt'               => 'required',
            'rw'               => 'required',
            'dampak'           => 'required',
            'status_kejadian'  => 'required',
            'keterangan'       => 'nullable',

            'foto'             => 'nullable|image|max:4096',
            'files.*'          => 'nullable|mimes:jpg,jpeg,png,mp4,avi,pdf,doc,docx|max:12288'
        ]);

        // Update foto utama
        if ($request->hasFile('foto')) {

            if ($kejadian->foto && Storage::disk('public')->exists($kejadian->foto)) {
                Storage::disk('public')->delete($kejadian->foto);
            }

            $validated['foto'] = $request->file('foto')->store('kejadian/foto_utama', 'public');
        }

        $kejadian->update($validated);

        // Upload dokumentasi tambahan
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('kejadian/dokumentasi', $filename, 'public');

                KejadianFile::create([
                    'kejadian_id' => $kejadian->kejadian_id,
                    'nama_file'   => $filename,
                    'tipe'        => $file->extension()
                ]);
            }
        }

        return redirect()->route('kejadian.index')->with('success', 'Perubahan berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE (hapus kejadian + semua dokumentasi)
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $kejadian = KejadianBencana::with('files')->findOrFail($id);

        // Delete foto utama
        if ($kejadian->foto && Storage::disk('public')->exists($kejadian->foto)) {
            Storage::disk('public')->delete($kejadian->foto);
        }

        // Delete dokumentasi
        foreach ($kejadian->files as $file) {
            $path = 'kejadian/dokumentasi/' . $file->nama_file;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $file->delete();
        }

        $kejadian->delete();

        return redirect()->route('kejadian.index')->with('success', 'Data berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE FILE DOKUMENTASI (FITUR OPSI A)
    |--------------------------------------------------------------------------
    */
    public function deleteFile($id)
    {
        $file = KejadianFile::findOrFail($id);

        $path = 'kejadian/dokumentasi/' . $file->nama_file;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $file->delete();

        return back()->with('success', 'File dokumentasi berhasil dihapus.');
    }
}
