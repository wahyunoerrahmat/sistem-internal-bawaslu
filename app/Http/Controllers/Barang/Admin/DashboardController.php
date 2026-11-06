<?php

namespace App\Http\Controllers\Barang\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKendaraan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        // =========================
        // FILTER TANGGAL
        // =========================

        $tanggalMulai = $request->tanggal_mulai
            ? Carbon::parse($request->tanggal_mulai)->startOfDay()
            : Carbon::now()->startOfMonth();

        $tanggalAkhir = $request->tanggal_akhir
            ? Carbon::parse($request->tanggal_akhir)->endOfDay()
            : Carbon::now()->endOfDay();


        // =========================
        // STATISTIK BARANG
        // =========================

        // total barang
        $totalBarang = BarangKendaraan::count();

        // barang tersedia
        $barangTersedia = BarangKendaraan::where('status','tersedia')->count();

        // barang dipinjam
        $barangDipinjam = BarangKendaraan::where('status','dipinjam')->count();


        // =========================
        // DATA GRAFIK (BERDASARKAN TANGGAL)
        // =========================

        $chart = BarangKendaraan::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal','ASC')
            ->get();


        $labels = $chart->pluck('tanggal');
        $data = $chart->pluck('total');


        // =========================
        // RETURN VIEW
        // =========================

        return view('barang.admin.dashboard',[
            'totalBarang' => $totalBarang,
            'barangTersedia' => $barangTersedia,
            'barangDipinjam' => $barangDipinjam,
            'labels' => $labels,
            'data' => $data,
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir
        ]);

    }
}