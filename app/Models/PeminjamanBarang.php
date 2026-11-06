<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanBarang extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_barang';

    /*
    =====================================
    FILLABLE (FIELD YANG BOLEH DISIMPAN)
    =====================================
    */
    protected $fillable = [
        'barang_id',
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_real',
        'status',
        'jumlah',
        'foto_kondisi_pinjam',
        'foto_kondisi_kembali'
    ];

    /*
    =====================================
    CAST DATE (AUTO CARBON)
    =====================================
    */
    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali_rencana' => 'datetime',
        'tanggal_kembali_real' => 'datetime',
    ];

    /*
    =====================================
    RELASI BARANG
    =====================================
    */
    public function barang()
    {
        return $this->belongsTo(
            BarangKendaraan::class,
            'barang_id'
        );
    }

    /*
    =====================================
    RELASI USER / PEGAWAI
    =====================================
    */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /*
    =====================================
    HELPER STATUS
    =====================================
    */

    // cek masih dipinjam
    public function isDipinjam()
    {
        return $this->status === 'dipinjam';
    }

    // cek sudah dikembalikan
    public function isDikembalikan()
    {
        return $this->status === 'dikembalikan';
    }

    /*
    =====================================
    CEK TERLAMBAT
    =====================================
    */
    public function isTerlambat()
    {
        if (!$this->tanggal_kembali_rencana || $this->status !== 'dipinjam') {
            return false;
        }

        return now()->greaterThan($this->tanggal_kembali_rencana);
    }

    /*
    =====================================
    ACCESSOR FOTO PINJAM
    =====================================
    */
    public function getFotoPinjamUrlAttribute()
    {
        if (!$this->foto_kondisi_pinjam) {
            return null;
        }

        return asset('storage/'.$this->foto_kondisi_pinjam);
    }

    /*
    =====================================
    ACCESSOR FOTO KEMBALI
    =====================================
    */
    public function getFotoKembaliUrlAttribute()
    {
        if (!$this->foto_kondisi_kembali) {
            return null;
        }

        return asset('storage/'.$this->foto_kondisi_kembali);
    }
}