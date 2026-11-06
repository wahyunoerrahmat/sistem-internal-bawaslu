<?php

namespace App\Http\Controllers\Barang\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeminjamanBarang;
use App\Models\BarangKendaraan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{

    /*
    =====================================================
    LIST DATA PEMINJAMAN
    =====================================================
    */
    public function index(Request $request)
    {
        $query = PeminjamanBarang::with(['barang', 'user']);

        // SEARCH
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->whereHas('barang', function ($barang) use ($request) {

                    $barang->where('jenis_barang', 'like', '%' . $request->search . '%')
                           ->orWhere('nup', 'like', '%' . $request->search . '%');

                })

                ->orWhereHas('user', function ($user) use ($request) {

                    $user->where('name', 'like', '%' . $request->search . '%');

                });

            });
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get();

        return view(
            'barang.admin.peminjaman.index',
            compact('data')
        );
    }


    /*
    =====================================================
    FORM PEMINJAMAN ADMIN
    =====================================================
    */
    public function create()
    {
        $barang = BarangKendaraan::where('status', 'tersedia')->get();
        $users  = User::all();

        return view(
            'barang.admin.peminjaman.create',
            compact('barang', 'users')
        );
    }


    /*
    =====================================================
    SIMPAN PEMINJAMAN
    =====================================================
    */
    public function store(Request $request)
    {

        $request->validate([
            'barang_id' => 'required|exists:barang_kendaraan,id',
            'user_id'   => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam',
            'foto_kondisi_pinjam' => 'nullable|image|max:2048'
        ]);

        DB::transaction(function () use ($request) {

            $fotoPath = null;

            if ($request->hasFile('foto_kondisi_pinjam')) {

                $fotoPath = $request->file('foto_kondisi_pinjam')
                    ->store('foto_kondisi_pinjam','public');
            }

            // SIMPAN PEMINJAMAN
            PeminjamanBarang::create([
                'barang_id' => $request->barang_id,
                'user_id'   => $request->user_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'foto_kondisi_pinjam' => $fotoPath,
                'status' => 'dipinjam',
            ]);

            // UPDATE STATUS BARANG
            BarangKendaraan::where('id', $request->barang_id)
                ->update([
                    'status' => 'dipinjam'
                ]);
        });

        return redirect()
            ->route('barang.admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibuat.');
    }


    /*
    =====================================================
    PENGEMBALIAN BARANG + FOTO KONDISI KEMBALI
    =====================================================
    */
    public function kembali(Request $request, $id)
    {
        $request->validate([
            'foto_kondisi_kembali' => 'required|image|max:2048'
        ]);

        try {

            DB::transaction(function () use ($request, $id) {

                $peminjaman = PeminjamanBarang::lockForUpdate()
                    ->findOrFail($id);

                $barang = BarangKendaraan::lockForUpdate()
                    ->findOrFail($peminjaman->barang_id);

                /*
                =============================
                UPLOAD FOTO KONDISI KEMBALI
                =============================
                */
                $fotoPath = null;

                if ($request->hasFile('foto_kondisi_kembali')) {

                    $fotoPath = $request->file('foto_kondisi_kembali')
                        ->store('foto_kondisi_kembali','public');
                }

                /*
                =============================
                UPDATE DATA PEMINJAMAN
                =============================
                */

                $peminjaman->update([
                    'tanggal_kembali_real' => now(),
                    'foto_kondisi_kembali' => $fotoPath,
                    'status' => 'dikembalikan'
                ]);

                /*
                =============================
                UPDATE STATUS BARANG
                =============================
                */

                $barang->update([
                    'status' => 'tersedia'
                ]);

            });

            return redirect()->back()->with(
                'success',
                'Barang berhasil dikembalikan.'
            );

        } catch (\Exception $e) {

            return redirect()->back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

}