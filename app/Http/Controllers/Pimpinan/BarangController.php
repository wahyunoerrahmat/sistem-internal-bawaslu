<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\BarangKendaraan;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = BarangKendaraan::orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('pimpinan.barang.index', compact('barangs'));
    }

    public function laporan()
    {
        return view('pimpinan.barang.laporan');
    }
}
