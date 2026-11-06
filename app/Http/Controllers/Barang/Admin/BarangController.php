<?php

namespace App\Http\Controllers\Barang\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKendaraan;

class BarangController extends Controller
{
    /*
    =====================================================
    DATA BARANG ADMIN
    =====================================================
    */
    public function index(Request $request)
    {
        $query = BarangKendaraan::with('peminjamanAktif');

        /*
        ==========================
        SEARCH BARANG
        ==========================
        */
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('jenis_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('nup', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }

        /*
        ==========================
        FILTER STATUS OTOMATIS
        ==========================
        */
        if ($request->filled('status')) {

            if ($request->status === 'dipinjam') {
                $query->whereHas('peminjamanAktif');
            }

            if ($request->status === 'tersedia') {
                $query->whereDoesntHave('peminjamanAktif');
            }
        }

        /*
        ==========================
        AMBIL DATA
        ==========================
        */
        $data = $query->latest()->get();

        return view(
            'barang.admin.barang.index',
            compact('data')
        );
    }
}