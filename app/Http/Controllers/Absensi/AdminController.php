<?php

namespace App\Http\Controllers\Absensi;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Halaman data absensi admin
     */
    public function index()
    {
        return view('absensi.admin.index');
    }

    /**
     * Halaman laporan absensi
     */
    public function laporan()
    {
        return view('absensi.admin.laporan');
    }
}
