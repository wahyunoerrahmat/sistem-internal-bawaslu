<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Tamu;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * ====================================
     * DASHBOARD RESEPSIONIS
     * ====================================
     */
    public function index()
    {
        /*
        |------------------------------------
        | TOTAL TAMU HARI INI
        |------------------------------------
        */
        $hariIni = Tamu::whereDate(
            'waktu_datang',
            Carbon::today()
        )->count();


        /*
        |------------------------------------
        | TOTAL TAMU BULAN INI
        |------------------------------------
        */
        $bulanIni = Tamu::whereMonth(
                'waktu_datang',
                Carbon::now()->month
            )
            ->whereYear(
                'waktu_datang',
                Carbon::now()->year
            )
            ->count();


        /*
|------------------------------------
| TOTAL TAMU MINGGU INI
|------------------------------------
*/
$mingguIni = Tamu::whereBetween(
    'waktu_datang',
    [
        Carbon::now()->startOfWeek(),
        Carbon::now()->endOfWeek()
    ]
)->count();


        /*
        |------------------------------------
        | DATA TAMU TERBARU
        |------------------------------------
        */
        $tamus = Tamu::latest('waktu_datang')
            ->limit(5)
            ->get();


        /*
        |------------------------------------
        | RETURN VIEW
        |------------------------------------
        */
        return view('resepsionis.dashboard', [
            'hariIni'  => $hariIni,
            'bulanIni' => $bulanIni,
            'mingguIni' => $mingguIni,
            'tamus'    => $tamus,
        ]);
    }
}