<?php

namespace App\Http\Controllers\Barang\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{

    /*
    =====================================================
    HALAMAN LAPORAN PEMINJAMAN BARANG
    =====================================================
    */
    public function index(Request $request)
    {

        $query = PeminjamanBarang::with([
            'barang',
            'user'
        ]);

        /*
        =====================================================
        FILTER TANGGAL
        =====================================================
        */
        if ($request->filled('start') && $request->filled('end')) {

            $query->whereBetween('tanggal_pinjam', [
                $request->start,
                $request->end
            ]);
        }

        /*
        =====================================================
        FILTER PEGAWAI
        =====================================================
        */
        if ($request->filled('user_id')) {

            $query->where('user_id', $request->user_id);
        }

        /*
        =====================================================
        SEARCH NAMA BARANG / NUP
        =====================================================
        */
        if ($request->filled('search')) {

            $query->whereHas('barang', function ($q) use ($request) {

                $q->where('jenis_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('nup', 'like', '%' . $request->search . '%');

            });
        }

        /*
        =====================================================
        FILTER STATUS
        =====================================================
        */
        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }

        /*
        =====================================================
        AMBIL DATA
        =====================================================
        */
        $laporan = $query
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        /*
        =====================================================
        AMBIL DATA PEGAWAI SAJA
        =====================================================
        */
        $users = User::where('role', 'pegawai')
            ->orderBy('name')
            ->get();

        /*
        =====================================================
        KIRIM KE VIEW
        =====================================================
        */
        return view('barang.admin.laporan.index', [
            'laporan' => $laporan,
            'users' => $users
        ]);
    }



    /*
    =====================================================
    EXPORT PDF SESUAI FILTER
    =====================================================
    */
    public function exportPdf(Request $request)
    {

        $query = PeminjamanBarang::with([
            'barang',
            'user'
        ]);

        /*
        =====================================================
        FILTER TANGGAL
        =====================================================
        */
        if ($request->filled('start') && $request->filled('end')) {

            $query->whereBetween('tanggal_pinjam', [
                $request->start,
                $request->end
            ]);
        }

        /*
        =====================================================
        FILTER PEGAWAI
        =====================================================
        */
        if ($request->filled('user_id')) {

            $query->where('user_id', $request->user_id);
        }

        /*
        =====================================================
        FILTER STATUS
        =====================================================
        */
        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }

        /*
        =====================================================
        SEARCH BARANG
        =====================================================
        */
        if ($request->filled('search')) {

            $query->whereHas('barang', function ($q) use ($request) {

                $q->where('jenis_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('nup', 'like', '%' . $request->search . '%');

            });
        }

        $laporan = $query
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        /*
        =====================================================
        GENERATE PDF
        =====================================================
        */
        $pdf = Pdf::loadView(
            'barang.admin.laporan.pdf',
            compact('laporan')
        )->setPaper('A4', 'landscape');

        return $pdf->download('laporan_peminjaman_barang.pdf');
    }

}