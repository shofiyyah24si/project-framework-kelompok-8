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
    $query = KejadianBencana::query();

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

    if ($request->rt) $query->where('rt', $request->rt);
    if ($request->rw) $query->where('rw', $request->rw);
    if ($request->status) $query->where('status_kejadian', $request->status);

    $data = $query->latest()->paginate(5)->withQueryString();
    $listRT = KejadianBencana::select('rt')->distinct()->orderBy('rt')->pluck('rt');
    $listRW = KejadianBencana::select('rw')->distinct()->orderBy('rw')->pluck('rw');
    
    // ⬇️⬇️⬇️ INI YANG DIUBAH ⬇️⬇️⬇️
    $listStatus = ['Dilaporkan', 'Verifikasi', 'Selesai'];
    // ⬆️⬆️⬆️ GANTI SAJA INI ⬆️⬆️⬆️
    
    // ========== TAMBAHKAN KEDUA VARIABLE INI ==========
    $listLogistik = \App\Models\LogistikBencana::all();
    $listPosko = \App\Models\PoskoBencana::all();
    // ========== PERBAIKAN SELESAI ==========

    return view('kejadian.index', compact(
        'data', 
        'listRT', 
        'listRW', 
        'listStatus',
        'listLogistik',
        'listPosko'
    ));
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
    | STORE (Foto Utama + Multiple Files) — UNLIMITED VERSION
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_bencana'   => 'required|string|max:255',
            'tanggal'         => 'required|date',
            'lokasi_text'     => 'required|string|max:255',
            'rt'              => 'required|string|max:10',
            'rw'              => 'required|string|max:10',
            'dampak'          => 'required|string',
            'status_kejadian' => 'required|in:Dilaporkan,Verifikasi,Selesai',
            'keterangan'      => 'nullable|string',

            // Foto utama
            'foto'            => 'nullable|image|max:2048',

            // Multiple upload
            'files'           => 'nullable|array',
            'files.*'         => 'nullable|file|max:5120|mimetypes:image/*,video/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);

        // Format tanggal ke Y-m-d (jika belum menggunakan $casts di Model)
        $validated['tanggal'] = date('Y-m-d', strtotime($validated['tanggal']));

        // Simpan foto utama (kalau ada)
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kejadian/foto_utama', 'public');
        }

        $kejadian = KejadianBencana::create($validated);

        // PERBAIKAN: KOMENTARI UPLOAD KE TABEL kejadian_files KARENA TABEL TIDAK ADA
        // Upload dokumentasi tambahan (kalau ada)
        // if ($request->hasFile('files')) {
        //     foreach ($request->file('files') as $file) {
        //         $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //         $file->storeAs('kejadian/dokumentasi', $filename, 'public');
        // 
        //         KejadianFile::create([
        //             'kejadian_id' => $kejadian->kejadian_id,
        //             'nama_file'   => $filename,
        //             'tipe'        => $file->extension(),
        //         ]);
        //     }
        // }

        return redirect()
            ->route('kejadian.index')
            ->with('success', 'Data kejadian berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW (Detail)
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        // PERBAIKAN: HAPUS with('files')
        $data = KejadianBencana::findOrFail($id); // HAPUS: ->with('files')
        return view('kejadian.show', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        // PERBAIKAN: HAPUS with('files')
        $data = KejadianBencana::findOrFail($id); // HAPUS: ->with('files')
        
        return view('kejadian.edit', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE — UNLIMITED VERSION
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        // PERBAIKAN: HAPUS with('files')
        $kejadian = KejadianBencana::findOrFail($id); // HAPUS: ->with('files')

        $validated = $request->validate([
            'jenis_bencana'   => 'required|string|max:255',
            'tanggal'         => 'required|date',
            'lokasi_text'     => 'required|string|max:255',
            'rt'              => 'required|string|max:10',
            'rw'              => 'required|string|max:10',
            'dampak'          => 'required|string',
            'status_kejadian' => 'required|in:Dilaporkan,Verifikasi,Selesai',
            'keterangan'      => 'nullable|string',

            'foto'            => 'nullable|image|max:2048',
            'files'           => 'nullable|array',
            'files.*'         => 'nullable|file|max:5120|mimetypes:image/*,video/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);

        // Format tanggal ke Y-m-d (jika belum menggunakan $casts di Model)
        $validated['tanggal'] = date('Y-m-d', strtotime($validated['tanggal']));

        // Update foto utama (kalau diisi baru)
        if ($request->hasFile('foto')) {
            if ($kejadian->foto && Storage::disk('public')->exists($kejadian->foto)) {
                Storage::disk('public')->delete($kejadian->foto);
            }

            $validated['foto'] = $request->file('foto')->store('kejadian/foto_utama', 'public');
        } else {
            // Jika tidak ada foto baru, pertahankan foto lama
            $validated['foto'] = $kejadian->foto;
        }

        // Update data utama
        $kejadian->update($validated);

        // PERBAIKAN: KOMENTARI UPLOAD KE TABEL kejadian_files
        // Upload dokumentasi tambahan (kalau ada)
        // if ($request->hasFile('files')) {
        //     foreach ($request->file('files') as $file) {
        //         $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //         $file->storeAs('kejadian/dokumentasi', $filename, 'public');
        // 
        //         KejadianFile::create([
        //             'kejadian_id' => $kejadian->kejadian_id,
        //             'nama_file'   => $filename,
        //             'tipe'        => $file->extension(),
        //         ]);
        //     }
        // }

        return redirect()
            ->route('kejadian.index')
            ->with('success', 'Perubahan berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE KEJADIAN
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        // PERBAIKAN: HAPUS with('files')
        $kejadian = KejadianBencana::findOrFail($id); // HAPUS: ->with('files')

        // Hapus foto utama
        if ($kejadian->foto && Storage::disk('public')->exists($kejadian->foto)) {
            Storage::disk('public')->delete($kejadian->foto);
        }

        // PERBAIKAN: KOMENTARI PENGHAPUSAN FILE DOKUMENTASI
        // Hapus file dokumentasi
        // foreach ($kejadian->files as $file) {
        //     $path = 'kejadian/dokumentasi/' . $file->nama_file;
        //     if (Storage::disk('public')->exists($path)) {
        //         Storage::disk('public')->delete($path);
        //     }
        //     $file->delete();
        // }

        $kejadian->delete();

        return redirect()->route('kejadian.index')->with('success', 'Data berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE FILE DOKUMENTASI
    |--------------------------------------------------------------------------
    */
    public function deleteFile($id)
    {
        // PERBAIKAN: KOMENTARI METHOD INI KARENA TABEL kejadian_files TIDAK ADA
        // $file = KejadianFile::findOrFail($id);
        // 
        // $path = 'kejadian/dokumentasi/' . $file->nama_file;
        // 
        // if (Storage::disk('public')->exists($path)) {
        //     Storage::disk('public')->delete($path);
        // }
        // 
        // $file->delete();
        // 
        // return back()->with('success', 'File dokumentasi berhasil dihapus.');
        
        // Alternatif: langsung return tanpa action
        return back()->with('info', 'Fitur penghapusan file dokumentasi dinonaktifkan.');
    }
}