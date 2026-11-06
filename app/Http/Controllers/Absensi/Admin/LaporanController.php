<?php

namespace App\Http\Controllers\Absensi\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{

    /*
    =================================
    HALAMAN LAPORAN
    =================================
    */

    public function index(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;
        $userId       = $request->user_id;

        $query = Absensi::with('user');

        /*
        =================================
        FILTER TANGGAL
        =================================
        */

        if ($tanggalMulai && $tanggalAkhir) {

            $start = Carbon::parse($tanggalMulai);
            $end   = Carbon::parse($tanggalAkhir);

            // jika tanggal terbalik
            if ($start->gt($end)) {
                [$start, $end] = [$end, $start];
            }

            $query->whereBetween('tanggal', [
                $start->format('Y-m-d'),
                $end->format('Y-m-d')
            ]);
        } 
        elseif ($tanggalMulai) {

            $query->whereDate('tanggal', '>=', $tanggalMulai);

        } 
        elseif ($tanggalAkhir) {

            $query->whereDate('tanggal', '<=', $tanggalAkhir);

        }

        /*
        =================================
        FILTER USER
        =================================
        */

        if ($userId) {
            $query->where('user_id', $userId);
        }

        /*
        =================================
        AMBIL DATA
        =================================
        */

        $data = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('jam_masuk')
            ->get();

        $users = User::where('role', 'magang')
            ->orderBy('name')
            ->get();

        return view('absensi.admin.laporan', [
            'data' => $data,
            'users' => $users,
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir,
            'userId' => $userId
        ]);
    }



    /*
    =================================
    EXPORT PDF LAPORAN
    =================================
    */

    public function exportPdf(Request $request)
    {

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;
        $userId       = $request->user_id;

        $query = Absensi::with('user');

        /*
        =================================
        FILTER TANGGAL
        =================================
        */

        if ($tanggalMulai && $tanggalAkhir) {

            $start = Carbon::parse($tanggalMulai);
            $end   = Carbon::parse($tanggalAkhir);

            if ($start->gt($end)) {
                [$start, $end] = [$end, $start];
            }

            $query->whereBetween('tanggal', [
                $start->format('Y-m-d'),
                $end->format('Y-m-d')
            ]);
        } 
        elseif ($tanggalMulai) {

            $query->whereDate('tanggal', '>=', $tanggalMulai);

        } 
        elseif ($tanggalAkhir) {

            $query->whereDate('tanggal', '<=', $tanggalAkhir);

        }

        /*
        =================================
        FILTER USER
        =================================
        */

        if ($userId) {
            $query->where('user_id', $userId);
        }

        /*
        =================================
        AMBIL DATA
        =================================
        */

        $data = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('jam_masuk')
            ->get();


        $pdf = Pdf::loadView(
            'absensi.admin.pdf',
            compact('data', 'tanggalMulai', 'tanggalAkhir', 'userId')
        )->setPaper('A4', 'landscape');


        return $pdf->download('laporan-absensi.pdf');
    }

}