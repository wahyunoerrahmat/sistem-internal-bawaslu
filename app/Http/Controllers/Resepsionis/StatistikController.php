<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Tamu;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {

        /*
        ===============================
        TOTAL TAMU HARI INI
        ===============================
        */
        $hariIni = Tamu::whereDate('waktu_datang', Carbon::today())->count();


        /*
        ===============================
        TOTAL TAMU BULAN INI
        ===============================
        */
        $bulanIni = Tamu::whereMonth('waktu_datang', Carbon::now()->month)
            ->whereYear('waktu_datang', Carbon::now()->year)
            ->count();


        /*
        ===============================
        GRAFIK TAMU PER BULAN
        ===============================
        */

        $labels = [];
        $data   = [];

        for ($i = 1; $i <= 12; $i++) {

            $labels[] = Carbon::create()
                ->month($i)
                ->locale('id')
                ->translatedFormat('F'); // Januari, Februari dll

            $data[] = Tamu::whereMonth('waktu_datang', $i)
                ->whereYear('waktu_datang', Carbon::now()->year)
                ->count();
        }


        return view('resepsionis.statistik', compact(
            'hariIni',
            'bulanIni',
            'labels',
            'data'
        ));
    }
}