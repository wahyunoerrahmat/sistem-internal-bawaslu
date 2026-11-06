<?php

namespace App\Http\Controllers\Absensi\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        =========================================
        AMBIL FILTER TANGGAL
        =========================================
        */

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;

        if ($tanggalMulai && $tanggalAkhir) {

            $tanggalMulai = Carbon::parse($tanggalMulai);
            $tanggalAkhir = Carbon::parse($tanggalAkhir);

            if ($tanggalMulai->gt($tanggalAkhir)) {
                [$tanggalMulai, $tanggalAkhir] = [$tanggalAkhir, $tanggalMulai];
            }

        } else {

            // default hari ini
            $tanggalMulai = Carbon::today();
            $tanggalAkhir = Carbon::today();
        }


        /*
        =========================================
        TOTAL MAGANG
        =========================================
        */

        $totalMagang = User::where('role','magang')->count();


        /*
        =========================================
        HADIR (BERDASARKAN FILTER)
        =========================================
        */

        $hadirHariIni = Absensi::whereBetween('tanggal',[
                $tanggalMulai->format('Y-m-d'),
                $tanggalAkhir->format('Y-m-d')
            ])
            ->whereNotNull('jam_masuk')
            ->count();


        /*
        =========================================
        TERLAMBAT (BERDASARKAN FILTER)
        =========================================
        */

        $terlambat = Absensi::whereBetween('tanggal',[
                $tanggalMulai->format('Y-m-d'),
                $tanggalAkhir->format('Y-m-d')
            ])
            ->where('status','terlambat')
            ->count();


        /*
        =========================================
        BELUM ABSEN
        =========================================
        */

        $userSudahPresensi = Absensi::whereBetween('tanggal',[
                $tanggalMulai->format('Y-m-d'),
                $tanggalAkhir->format('Y-m-d')
            ])
            ->pluck('user_id');

        $belumPresensi = User::where('role','magang')
            ->whereNotIn('id',$userSudahPresensi)
            ->count();


        /*
        =========================================
        DATA ABSENSI BERDASARKAN FILTER
        =========================================
        */

        $absensiHariIni = Absensi::with('user')
            ->whereBetween('tanggal',[
                $tanggalMulai->format('Y-m-d'),
                $tanggalAkhir->format('Y-m-d')
            ])
            ->orderBy('jam_masuk','desc')
            ->get();


        /*
        =========================================
        DATA GRAFIK
        =========================================
        */

        $query = Absensi::whereNotNull('jam_masuk');

        if ($request->tanggal_mulai && $request->tanggal_akhir) {

            $query->whereBetween('tanggal',[
                $tanggalMulai->format('Y-m-d'),
                $tanggalAkhir->format('Y-m-d')
            ]);

        } else {

            // default grafik 6 bulan terakhir
            $query->whereDate('tanggal','>=',Carbon::now()->subMonths(6));
        }


        $data = $query
            ->selectRaw("DATE_FORMAT(tanggal,'%d %b') as hari, COUNT(*) as total")
            ->groupBy('hari')
            ->orderByRaw("MIN(tanggal)")
            ->get();


        $bulan = $data->pluck('hari');
        $jumlahAbsensi = $data->pluck('total');


        /*
        =========================================
        RETURN VIEW
        =========================================
        */

        return view('absensi.admin.dashboard',compact(
            'totalMagang',
            'hadirHariIni',
            'terlambat',
            'belumPresensi',
            'absensiHariIni',
            'bulan',
            'jumlahAbsensi'
        ));
    }
}