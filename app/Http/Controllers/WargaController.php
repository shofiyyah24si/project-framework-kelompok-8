<?php
namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataWarga'] = Warga::all();
        return view('admin.warga.index', $data);
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
        $data['no_ktp']        = $request->no_ktp;
        $data['nama']          = $request->nama;
        $data['jenis_kelamin'] = $request->jenis_kelamin;
        $data['agama']         = $request->agama;
        $data['pekerjaan']     = $request->pekerjaan;
        $data['telp']          = $request->telp;
        $data['email']         = $request->email;

        Warga::create($data);

        return redirect()->route('warga.index')->with('success', 'Penambahan Data Berhasil!');
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
        $data['dataWarga'] = Warga::findOrFail($id);
        return view('admin.warga.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warga = Warga::findOrFail($id);

        $warga->delete();
        return redirect()->route('warga.index')->with('update', 'Data berhasil dihapus');
    }
}
