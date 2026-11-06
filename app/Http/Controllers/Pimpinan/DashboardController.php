<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Absensi;
use App\Models\BarangKendaraan;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER BULAN & TAHUN
        |--------------------------------------------------------------------------
        */
        $bulan = $request->bulan;
        $tahun = $request->tahun ?? date('Y');


        /*
        |--------------------------------------------------------------------------
        | STATISTIK ADMIN
        |--------------------------------------------------------------------------
        */
        $totalAdmin = User::whereIn('role',[
            'admin_absensi',
            'admin_barang',
            'resepsionis'
        ])->count();


        /*
        |--------------------------------------------------------------------------
        | QUERY ABSENSI (FILTER)
        |--------------------------------------------------------------------------
        */
        $absensiQuery = Absensi::query();

        if ($bulan) {
            $absensiQuery->whereMonth('created_at',$bulan);
        }

        if ($tahun) {
            $absensiQuery->whereYear('created_at',$tahun);
        }

        $totalAbsensi    = $absensiQuery->count();
        $totalHadir      = (clone $absensiQuery)->where('status','hadir')->count();
        $totalTidakHadir = (clone $absensiQuery)->where('status','tidak_hadir')->count();


        /*
        |--------------------------------------------------------------------------
        | ⭐ CHART ABSENSI BERDASARKAN STATUS DATABASE
        |--------------------------------------------------------------------------
        */
        $chartAbsensi = Absensi::select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->when($bulan,function($q) use ($bulan){
                $q->whereMonth('created_at',$bulan);
            })
            ->when($tahun,function($q) use ($tahun){
                $q->whereYear('created_at',$tahun);
            })
            ->groupBy('status')
            ->get();

        $labelsAbsensi = [];
        $dataAbsensi   = [];

        foreach ($chartAbsensi as $row) {
            $labelsAbsensi[] = ucfirst($row->status);
            $dataAbsensi[]   = $row->total;
        }

        // Hindari chart kosong
        if(empty($labelsAbsensi)){
            $labelsAbsensi = ['Belum Ada Data'];
            $dataAbsensi   = [0];
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTIK BARANG KENDARAAN
        |--------------------------------------------------------------------------
        */
        $totalBarang = BarangKendaraan::count();

        $barangTersedia = BarangKendaraan::
            whereRaw('LOWER(status)="tersedia"')
            ->count();

        $barangDipinjam = BarangKendaraan::
            whereRaw('LOWER(status)="dipinjam"')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */
        return view('pimpinan.dashboard', compact(
            'totalAdmin',
            'totalAbsensi',
            'totalHadir',
            'totalTidakHadir',
            'totalBarang',
            'barangTersedia',
            'barangDipinjam',
            'labelsAbsensi',
            'dataAbsensi',
            'bulan',
            'tahun'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function exportPdf()
    {
        $data = [
            'totalAdmin' =>
                User::whereIn('role',['admin_absensi','admin_barang'])->count(),

            'totalAbsensi' =>
                Absensi::count(),

            'totalHadir' =>
                Absensi::where('status','hadir')->count(),

            'totalTidakHadir' =>
                Absensi::where('status','tidak_hadir')->count(),

            'totalBarang' =>
                BarangKendaraan::count(),

            'barangTersedia' =>
                BarangKendaraan::whereRaw('LOWER(status)="tersedia"')->count(),

            'barangDipinjam' =>
                BarangKendaraan::whereRaw('LOWER(status)="dipinjam"')->count(),

            'tanggalCetak' =>
                now()->format('d-m-Y H:i')
        ];

        $pdf = Pdf::loadView('pimpinan.laporan_pdf',$data);

        return $pdf->download('laporan_dashboard_pimpinan.pdf');
    }
}