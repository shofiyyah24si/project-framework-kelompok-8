<?php
<<<<<<< HEAD

namespace App\Http\Controllers;

=======
namespace App\Http\Controllers;

use App\Models\Warga;
>>>>>>> 9f485e18020f5ea0016bdb032c4f18d54946509b
use Illuminate\Http\Request;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
<<<<<<< HEAD
        //
=======
        $data['dataWarga'] = Warga::all();
        return view('admin.warga.index', $data);
>>>>>>> 9f485e18020f5ea0016bdb032c4f18d54946509b
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
<<<<<<< HEAD
        $data['no_ktp'] = $request->no_ktp;
        $data['nama'] = $request->nama;
        $data['jenis_kelamin'] = $request->jenis_kelamin;
        $data['agama'] = $request->agama;
        $data['pekerjaan'] = $request->pekerjaan;
        $data['telp'] = $request->telp;
        $data['email'] = $request->email;
         
        Warga::create($data);
        return redirect()->route('warga.index')->with('success','Penambahan Data Berhasil!');
=======
        $data['no_ktp']        = $request->no_ktp;
        $data['nama']          = $request->nama;
        $data['jenis_kelamin'] = $request->jenis_kelamin;
        $data['agama']         = $request->agama;
        $data['pekerjaan']     = $request->pekerjaan;
        $data['telp']          = $request->telp;
        $data['email']         = $request->email;

        Warga::create($data);

        return redirect()->route('warga.index')->with('success', 'Penambahan Data Berhasil!');
>>>>>>> 9f485e18020f5ea0016bdb032c4f18d54946509b
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
<<<<<<< HEAD
        //
=======
        $data['dataWarga'] = Warga::findOrFail($id);
        return view('admin.warga.edit', $data);
>>>>>>> 9f485e18020f5ea0016bdb032c4f18d54946509b
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
<<<<<<< HEAD
        //
=======
        $warga = $id;
        $warga    = Warga::findOrFail($id);

        $warga->no_ktp        = $request->no_ktp;
        $warga->nama          = $request->nama;
        $warga->jenis_kelamin = $request->jenis_kelamin;
        $warga->agama         = $request->agama;
        $warga->pekerjaan     = $request->pekerjaan;
        $warga->telp          = $request->telp;
        $warga->email         = $request->email;

        $warga->save();

        return redirect()->route('warga.index') ->with('success', 'Perubahan Data Berhasil!');
>>>>>>> 9f485e18020f5ea0016bdb032c4f18d54946509b
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
<<<<<<< HEAD
        //
=======
        $warga = Warga::findOrFail($id);

        $warga->delete();
        return redirect()->route('warga.index')->with('update', 'Data berhasil dihapus');
>>>>>>> 9f485e18020f5ea0016bdb032c4f18d54946509b
    }
}
