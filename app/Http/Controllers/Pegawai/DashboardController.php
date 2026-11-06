<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\BarangKendaraan;
use App\Models\PeminjamanBarang;

class DashboardController extends Controller
{

    /*
    =====================================================
    DASHBOARD PEGAWAI (STATISTIK + GRAFIK)
    =====================================================
    */
    public function index(Request $request)
    {
        $userId = Auth::id();

        /*
        =====================================
        FILTER TANGGAL
        =====================================
        */

        $tanggalMulai = $request->tanggal_mulai
            ? Carbon::parse($request->tanggal_mulai)->startOfDay()
            : Carbon::now()->startOfMonth();

        $tanggalAkhir = $request->tanggal_akhir
            ? Carbon::parse($request->tanggal_akhir)->endOfDay()
            : Carbon::now()->endOfDay();


        /*
        =====================================
        STATISTIK BARANG
        =====================================
        */

        $totalBarang = BarangKendaraan::count();

        $tersedia = BarangKendaraan::where('status', 'tersedia')->count();

        $dipinjam = BarangKendaraan::where('status', 'dipinjam')->count();

        $peminjamanSaya = PeminjamanBarang::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();


        /*
        =====================================
        DATA GRAFIK PEMINJAMAN
        =====================================
        */

        $chart = PeminjamanBarang::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $labels = $chart->pluck('tanggal');

        $data = $chart->pluck('total');


        /*
        =====================================
        RETURN VIEW
        =====================================
        */

        return view('pegawai.dashboard', [
            'totalBarang' => $totalBarang,
            'tersedia' => $tersedia,
            'dipinjam' => $dipinjam,
            'peminjamanSaya' => $peminjamanSaya,

            'labels' => $labels,
            'data' => $data,

            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir
        ]);
    }



    /*
    =====================================================
    MENU ABSENSI
    =====================================================
    */
    public function absensi()
    {
        return redirect()->route('absensi.pegawai.dashboard');
    }



    /*
    =====================================================
    DATA BARANG TERSEDIA
    =====================================================
    */
    public function barang()
    {
        $barang = BarangKendaraan::where('status', 'tersedia')
            ->latest()
            ->get();

        return view('pegawai.barang.index', compact('barang'));
    }



    /*
    =====================================================
    LAPORAN PEMINJAMAN PEGAWAI
    =====================================================
    */
    public function laporanPeminjaman()
    {
        $userId = Auth::id();

        $peminjaman = PeminjamanBarang::with('barang')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('pegawai.laporan.index', compact('peminjaman'));
    }



    /*
    =====================================================
    PINJAM BARANG
    =====================================================
    */
    public function pinjam(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'foto_kondisi_pinjam' => 'required|image|max:2048'
        ]);

        try {

            DB::transaction(function () use ($request, $id) {

                $barang = BarangKendaraan::lockForUpdate()
                    ->findOrFail($id);

                if ($barang->status !== 'tersedia') {
                    throw new \Exception('Barang sedang dipinjam.');
                }

                /*
                ==========================
                UPLOAD FOTO KONDISI
                ==========================
                */

                $foto = null;

                if ($request->hasFile('foto_kondisi_pinjam')) {
                    $foto = $request->file('foto_kondisi_pinjam')
                        ->store('foto_kondisi_pinjam', 'public');
                }


                /*
                ==========================
                SIMPAN DATA PEMINJAMAN
                ==========================
                */

                PeminjamanBarang::create([
                    'barang_id' => $barang->id,
                    'user_id' => Auth::id(),

                    'tanggal_pinjam' => now(),
                    'tanggal_kembali_rencana' => now()->addDays(7),

                    'jumlah' => $request->jumlah,
                    'foto_kondisi_pinjam' => $foto,

                    'status' => 'dipinjam'
                ]);


                /*
                ==========================
                UPDATE STATUS BARANG
                ==========================
                */

                $barang->update([
                    'status' => 'dipinjam'
                ]);

            });

            return back()->with('success', 'Barang berhasil dipinjam.');

        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());

        }
    }

}