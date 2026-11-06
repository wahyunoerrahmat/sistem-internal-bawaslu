<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::with('user')
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10);

        return view('pimpinan.absensi.index', compact('absensi'));
    }

    public function laporan()
    {
        return view('pimpinan.absensi.laporan');
    }
}
