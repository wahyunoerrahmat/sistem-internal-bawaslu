<?php

namespace App\Http\Controllers\Barang\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangKendaraan;
use Illuminate\Http\Request;
use App\Exports\BarangExport;
use App\Imports\BarangImport;
use Maatwebsite\Excel\Facades\Excel;

class BarangKendaraanController extends Controller
{
    /**
     * Daftar barang + search & filter
     */
    public function index(Request $request)
    {
        $query = BarangKendaraan::query();

        // Search berdasarkan jenis Barang, NUP, atau merk
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('jenis_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('nup', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get();

        return view('barang.admin.barang.index', compact('data'));
    }

    /**
     * Halaman pilih metode tambah barang
     */
    public function pilih()
    {
        return view('barang.admin.barang.pilih');
    }

    /**
     * Form input manual
     */
    public function create()
    {
        return view('barang.admin.barang.create');
    }

    /**
     * Simpan barang manual
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_urut'     => 'nullable|integer',
            'jenis_barang' => 'required|string|max:255',
            'nup' => 'required|string|max:100',
            'merk'        => 'nullable|string|max:255',
            'tipe'        => 'nullable|string|max:255',
            'kondisi'     => 'required|string',
            'status'      => 'required|string',
        ]);

        BarangKendaraan::create($request->only([
            'no_urut',
            'jenis_barang',
            'nup',
            'merk',
            'tipe',
            'kondisi',
            'status',
        ]));

        return redirect()
            ->route('barang.admin.barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Form edit barang
     */
    public function edit(BarangKendaraan $barang)
    {
        return view('barang.admin.barang.edit', compact('barang'));
    }

    /**
     * Update barang
     */
    public function update(Request $request, BarangKendaraan $barang)
    {
        $request->validate([
            'no_urut'     => 'nullable|integer',
            'jenis_barang'   => 'required|string|max:255',
            'nup' => 'required|string|max:100',
            'merk'        => 'nullable|string|max:255',
            'tipe'        => 'nullable|string|max:255',
            'kondisi'     => 'required|string',
            'status'      => 'required|string',
        ]);

        $barang->update($request->only([
            'no_urut',
            'jenis_barang',
            'nup',
            'merk',
            'tipe',
            'kondisi',
            'status',
        ]));

        return redirect()
            ->route('barang.admin.barang.index')
            ->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Hapus barang
     */
    public function destroy(BarangKendaraan $barang)
    {
        $barang->delete();

        return redirect()
            ->route('barang.admin.barang.index')
            ->with('success', 'Barang berhasil dihapus');
    }

    /**
     * Export data Barang ke Excel
     */
    public function export()
    {
        return Excel::download(new BarangExport, 'data-barang.xlsx');
    }

    /**
     * Form import Excel/CSV
     */
    public function importForm()
    {
        return view('barang.admin.barang.import');
    }

    /**
     * Proses import Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new BarangImport, $request->file('file'));

        return redirect()
            ->route('barang.admin.barang.index')
            ->with('success', 'Import data berhasil');
    }
}
