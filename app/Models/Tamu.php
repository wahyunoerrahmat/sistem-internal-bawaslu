<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $table = 'tamu';

    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'kontak',
        'keperluan',
        'pihak_dituju',
        'nama_penerima',
        'dokumentasi',
        'waktu_datang'
    ];
}