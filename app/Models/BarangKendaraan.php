<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PeminjamanBarang;

class BarangKendaraan extends Model
{
    protected $table = 'barang';

    /*
    =====================================================
    KONSTANTA STATUS (STANDARD SISTEM)
    =====================================================
    */
    const STATUS_TERSEDIA = 'tersedia';
    const STATUS_DIPINJAM = 'dipinjam';

    /*
    =====================================================
    MASS ASSIGNMENT
    =====================================================
    */
    protected $fillable = [
        'no_urut',
        'jenis_barang',
        'nup',
        'merk',
        'tipe',
        'kondisi',
        'status',
    ];

    /*
    =====================================================
    RELASI PEMINJAMAN
    =====================================================
    */

    /**
     * Semua riwayat peminjaman barang
     */
    public function peminjaman()
    {
        return $this->hasMany(
            PeminjamanBarang::class,
            'barang_id',
            'id'
        );
    }

    /**
     * Peminjaman aktif (barang sedang dipinjam)
     */
    public function peminjamanAktif()
    {
        return $this->hasOne(
            PeminjamanBarang::class,
            'barang_id',
            'id'
        )->where('status', self::STATUS_DIPINJAM);
    }

    /*
    =====================================================
    HELPER STATUS
    =====================================================
    */

    /**
     * Apakah barang tersedia
     */
    public function isTersedia()
    {
        return strtolower(trim($this->status))
            === self::STATUS_TERSEDIA;
    }

    /**
     * Apakah barang sedang dipinjam
     */
    public function sedangDipinjam()
    {
        return $this->peminjamanAktif()->exists();
    }

    /*
    =====================================================
    AUTO NORMALISASI STATUS
    =====================================================
    */

    /**
     * Pastikan status selalu lowercase & rapi
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] =
            strtolower(trim($value));
    }
}