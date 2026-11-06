<?php

namespace App\Http\Controllers\Absensi\Pegawai;

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
        $today = now()->toDateString();

        $absensi = Absensi::where('user_id',Auth::id())
            ->whereDate('tanggal',$today)
            ->first();

        $bolehPulang = false;

        if ($absensi &&
            $absensi->jam_masuk &&
            !$absensi->jam_pulang) {

            $jamSekarang = now()->format('H:i');
            $jamPulang = now()->isFriday()
                ? '16:30'
                : '16:00';

            if ($jamSekarang >= $jamPulang) {
                $bolehPulang = true;
            }
        }

        return view('absensi.pegawai.dashboard',[
            'absensi'=>$absensi,
            'bolehPulang'=>$bolehPulang
        ]);
    }


    /*
    =========================================================
    ABSEN MASUK
    =========================================================
    */
    public function storeMasuk(Request $request)
    {
        if(!$this->isHariKerja()){
            return back()->with('error','Hari ini bukan hari kerja');
        }

        $request->validate([
            'foto'=>'required'
        ]);

        $today = now()->toDateString();

        /*
        CEK SUDAH ABSEN
        */
        $cek = Absensi::where('user_id',Auth::id())
            ->whereDate('tanggal',$today)
            ->first();

        if($cek){
            return back()->with('error','Anda sudah absen hari ini');
        }

        /*
        STATUS OTOMATIS
        */
        $now = Carbon::now('Asia/Jakarta');

        $status = $now->format('H:i:s') <= '08:00:00'
            ? 'masuk'
            : 'terlambat';

        /*
        SIMPAN FOTO
        */
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
            ->route('absensi.pegawai.dashboard')
            ->with('success','Absen masuk berhasil');
    }


    /*
    =========================================================
    ABSEN PULANG
    =========================================================
    */
    public function storePulang(Request $request)
    {
        if(!$this->isHariKerja()){
            return back()->with('error','Hari ini bukan hari kerja');
        }

        $request->validate([
            'foto'=>'required'
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
            $request->foto,
            'pulang'
        );

        $absensi->update([
            'jam_pulang'=>$today->format('H:i:s'),
            'foto_pulang'=>$foto,
            'status'=>'pulang'
        ]);

        return redirect()
            ->route('absensi.pegawai.dashboard')
            ->with('success','Absen pulang berhasil');
    }


    /*
    =========================================================
    RIWAYAT ABSENSI
    =========================================================
    */
    public function riwayat()
    {
        $data = Absensi::where('user_id',Auth::id())
            ->latest()
            ->get();

        return view('absensi.pegawai.riwayat',compact('data'));
    }


    /*
    =========================================================
    HELPER
    =========================================================
    */
    private function isHariKerja()
    {
        return !Carbon::today()->isWeekend();
    }

    private function saveBase64Image($base64,$prefix)
    {
        $image = str_replace(
            'data:image/jpeg;base64,','',$base64
        );

        $image = str_replace(' ','+',$image);

        $name = $prefix.'_'.time().'.jpg';
        $path = 'pegawai/'.$name;

        Storage::disk('public')
            ->put($path,base64_decode($image));

        return $path;
    }
}