<?php

namespace App\Imports;

use App\Models\BarangKendaraan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BarangImport implements ToModel, WithStartRow
{
    /**
     * Mulai baca dari baris ke-2 (skip header)
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // Struktur kolom:
        // 0 No
        // 1 Jenis Barang
        // 2 NUP
        // 3 Nama Barang
        // 4 Merk
        // 5 Tipe

        if (empty($row[1]) || empty($row[3])) {
            return null;
        }

        return new BarangKendaraan([
            'no_urut'     => is_numeric($row[0]) ? $row[0] : null,
            'jenis_barang'   => $row[1],
            'nup'         => is_numeric($row[2]) ? $row[2] : null,
            'nama_barang' => $row[3] ?? null,
            'merk'        => $row[4] ?? '-',
            'tipe'        => $row[5] ?? '-',
            'kondisi'     => 'baik',
            'status'      => 'tersedia',
        ]);
    }
}
