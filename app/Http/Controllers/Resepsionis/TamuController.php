<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tamu;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TamuController extends Controller
{
    /**
     * =================================
     * LIST DATA TAMU
     * =================================
     */
    public function index()
    {
        $tamus = Tamu::latest()->get();

        return view('resepsionis.tamu_list', compact('tamus'));
    }


    /**
     * =================================
     * SIMPAN TAMU DATANG
     * =================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'      => 'required|string|max:100',
            'alamat'            => 'required|string|max:200',
            'kontak'            => 'nullable|string|max:100',
            'keperluan'         => 'required|string',
            'pihak_dituju'      => 'required|string|max:150',
            'nama_penerima'  => 'required|string|max:100',
            'dokumentasi'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $dokumentasi = null;

        if ($request->hasFile('dokumentasi')) {
            $dokumentasi = $request->file('dokumentasi')->store('tamu', 'public');
        }

        Tamu::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
            'keperluan'     => $request->keperluan,
            'pihak_dituju'  => $request->pihak_dituju,
            'nama_penerima' => $request->nama_penerima,
            'dokumentasi'          => $dokumentasi,
            'waktu_datang'  => now()
        ]);

        return back()->with('success', 'Tamu berhasil ditambahkan');
    }


    /**
     * =================================
     * FORM INPUT TAMU
     * =================================
     */
    public function create()
    {
        return view('resepsionis.tamu_input');
    }


    /**
     * =================================
     * FORM EDIT TAMU
     * =================================
     */
    public function edit($id)
    {
        $tamu = Tamu::findOrFail($id);

        return view('resepsionis.tamu_edit', compact('tamu'));
    }


    /**
     * =================================
     * UPDATE DATA TAMU
     * =================================
     */
    public function update(Request $request, $id)
    {
        $tamu = Tamu::findOrFail($id);

        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'alamat'        => 'required|string|max:200',
            'kontak'        => 'nullable|string|max:100',
            'keperluan'     => 'required|string',
            'pihak_dituju'  => 'required|string|max:150',
            'nama_penerima' => 'required|string|max:100',
            'dokumentasi'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $dokumentasi = $tamu->dokumentasi;

        if ($request->hasFile('dokumentasi')) {

            if ($tamu->dokumentasi) {
                Storage::disk('public')->delete($tamu->dokumentasi);
            }

            $dokumentasi = $request->file('dokumentasi')->store('tamu', 'public');
        }

        $tamu->update([
            'nama_lengkap'      => $request->nama_lengkap,
            'alamat'            => $request->alamat,
            'kontak'            => $request->kontak,
            'keperluan'         => $request->keperluan,
            'pihak_dituju'      => $request->pihak_dituju,
            'nama_penerima'  => $request->nama_penerima,
            'dokumentasi'       => $dokumentasi
        ]);

        return redirect()
            ->route('resepsionis.tamu')
            ->with('success', 'Data tamu berhasil diperbarui');
    }


    /**
     * =================================
     * HAPUS DATA TAMU
     * =================================
     */
    public function destroy($id)
    {
        $tamu = Tamu::findOrFail($id);

        if ($tamu->dokumentasi) {
            Storage::disk('public')->delete($tamu->dokumentasi);
        }

        $tamu->delete();

        return back()->with('success', 'Data tamu dihapus');
    }


/**
 * =================================
 * DOWNLOAD DATA TAMU
 * =================================
 */
public function download(Request $request)
{
    $format = $request->input('format');

    $tamus = Tamu::orderBy('waktu_datang','desc')->get();

    /*
    ==================================
    DOWNLOAD PDF
    ==================================
    */
    if ($format == 'pdf') {

        $pdf = Pdf::loadView('resepsionis.tamu_pdf', [
            'tamus' => $tamus
        ])->setPaper('A4','portrait');

        return $pdf->download('laporan_buku_tamu_bawaslu.pdf');
    }


        /*
        ==================================
        DOWNLOAD CSV (EXCEL)
        ==================================
        */
        $filename = "data_tamu.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function() use ($tamus) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Nama',
                'Alamat',
                'Kontak',
                'Keperluan',
                'Pihak Dituju',
                'Nama Penerima',
                'Dokumentasi',
                'Waktu Datang'
            ]);

            foreach ($tamus as $tamu) {

                fputcsv($file, [
                    $tamu->nama_lengkap,
                    $tamu->alamat,
                    $tamu->kontak,
                    $tamu->keperluan,
                    $tamu->pihak_dituju,
                    $tamu->nama_penerima,
                    $tamu->dokumentasi,
                    $tamu->waktu_datang
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback,200,$headers);
    }
}