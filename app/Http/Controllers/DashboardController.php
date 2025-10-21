<?php

namespace App\Http\Controllers;

use App\Models\Kejadian;
use App\Models\Relawan;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahKejadian = Kejadian::count();
        $jumlahRelawan = Relawan::count();

        // kirim data ringkasan saja, bukan daftar tabel
        return view('dashboard.index', compact('jumlahKejadian', 'jumlahRelawan'));
    }
}
