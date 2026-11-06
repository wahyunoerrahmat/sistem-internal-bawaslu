<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Tamu;

class ResepsionisController extends Controller
{
    public function index()
    {
        $tamu = Tamu::with('user')
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10);

        return view('pimpinan.resepsionis.index', compact('tamu'));
    }

    public function laporan()
    {
        return view('pimpinan.resepsionis.laporan');
    }
}
