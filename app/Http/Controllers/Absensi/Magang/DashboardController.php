<?php

namespace App\Http\Controllers\Absensi\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{

    /*
    =========================================================
    DASHBOARD
    =========================================================
    */

    public function index()
    {
        $userId = Auth::id();
        $today  = now()->toDateString();

        $absensiHariIni = Absensi::where('user_id',$userId)
            ->whereDate('tanggal',$today)
            ->first();

        /*
        ============================
        BOLEH PULANG
        ============================
        */

        $bolehPulang = false;

        if ($absensiHariIni &&
            $absensiHariIni->jam_masuk &&
            !$absensiHariIni->jam_pulang) {

            $jamSekarang = now()->format('H:i');
            $jamPulang   = now()->isFriday() ? '16:30' : '16:00';

            if ($jamSekarang >= $jamPulang) {
                $bolehPulang = true;
            }
        }

        /*
        ============================
        STATISTIK
        ============================
        */

        $total = Absensi::where('user_id',$userId)->count();

        $totalMasuk = Absensi::where('user_id',$userId)
            ->where('status','masuk')
            ->count();

        $totalTerlambat = Absensi::where('user_id',$userId)
            ->where('status','terlambat')
            ->count();

        $bulanIni = Absensi::where('user_id',$userId)
            ->whereMonth('tanggal',now()->month)
            ->whereYear('tanggal',now()->year)
            ->count();

        return view('absensi.magang.dashboard',[
            'absensi'=>$absensiHariIni,
            'bolehPulang'=>$bolehPulang,
            'total'=>$total,
            'totalMasuk'=>$totalMasuk,
            'totalTerlambat'=>$totalTerlambat,
            'bulanIni'=>$bulanIni
        ]);
    }


    /*
    =========================================================
    FORM MASUK
    =========================================================
    */

    public function formMasuk()
    {
        return view('absensi.magang.absen');
    }


    /*
    =========================================================
    ABSEN MASUK
    =========================================================
    */

    public function storeMasuk(Request $request)
    {

        $request->validate([
            'foto' => 'required'
        ]);

        $today = now()->toDateString();

        $cek = Absensi::where('user_id',Auth::id())
            ->whereDate('tanggal',$today)
            ->first();

        if ($cek) {
            return back()->with('error','Anda sudah absen hari ini');
        }

        $now = Carbon::now('Asia/Jakarta');

        $status = $now->format('H:i:s') <= '08:00:00'
            ? 'masuk'
            : 'terlambat';

        $foto = $this->saveBase64Image(
            $request->foto,
            'masuk'
        );

        Absensi::create([
            'user_id'=>Auth::id(),
            'tanggal'=>$today,
            'jam_masuk'=>$now->format('H:i:s'),
            'foto_masuk'=>$foto,
            'status'=>$status
        ]);

        return redirect()
            ->route('absensi.magang.dashboard')
            ->with('success','Absen masuk berhasil');

    }


    /*
    =========================================================
    FORM PULANG
    =========================================================
    */

    public function formPulang()
    {
        return view('absensi.magang.absen-pulang');
    }


    /*
    =========================================================
    ABSEN PULANG
    =========================================================
    */

    public function storePulang(Request $request)
    {

        $request->validate([
            'foto_pulang' => 'required'
        ]);

        $today = now();

        $absensi = Absensi::where('user_id',Auth::id())
            ->whereDate('tanggal',$today->toDateString())
            ->first();

        if(!$absensi){
            return back()->with('error','Belum absen masuk');
        }

        if($absensi->jam_pulang){
            return back()->with('error','Sudah absen pulang');
        }

        $jamPulang = $today->isFriday()
            ? '16:30'
            : '16:00';

        if($today->format('H:i') < $jamPulang){
            return back()->with('error','Belum waktunya pulang');
        }

        $foto = $this->saveBase64Image(
            $request->foto_pulang,
            'pulang'
        );

        $absensi->update([
            'jam_pulang'=>$today->format('H:i:s'),
            'foto_pulang'=>$foto,
            'status'=>'pulang'
        ]);

        return redirect()
            ->route('absensi.magang.dashboard')
            ->with('success','Absen pulang berhasil');

    }


    /*
    =========================================================
    HELPER SIMPAN FOTO
    =========================================================
    */

    private function saveBase64Image($base64,$prefix)
    {

        $image = preg_replace('#^data:image/\w+;base64,#i','',$base64);
        $image = str_replace(' ','+',$image);

        $name = $prefix.'_'.time().'.jpg';
        $path = 'absensi/'.$name;

        Storage::disk('public')->put($path,base64_decode($image));

        return $path;

    }


    /*
    =========================================================
    RIWAYAT ABSENSI
    =========================================================
    */

    public function riwayat()
    {

        $data = Absensi::where('user_id',Auth::id())
            ->orderBy('tanggal','desc')
            ->get();

        return view('absensi.magang.riwayat', compact('data'));

    }

}