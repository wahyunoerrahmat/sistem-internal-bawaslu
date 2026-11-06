<?php

namespace App\Exports;

use App\Models\BarangKendaraan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BarangKendaraan::select(
            'no_urut',
            'jenis_barang',
            'nup',
            'merk',
            'tipe',
            'kondisi',
            'status'
        )->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Barang',
            'NUP',
            'Merk',
            'Tipe',
            'Kondisi',
            'Status',
        ];
    }
}
