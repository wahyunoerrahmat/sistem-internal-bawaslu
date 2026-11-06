<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'foto_masuk',
        'foto_pulang',
    ];

    /**
     * Casting otomatis
     */
    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i:s',
        'jam_pulang' => 'datetime:H:i:s',
    ];

    /**
     * Selalu load relasi user otomatis
     */
    protected $with = ['user'];

    /**
     * Relasi ke tabel users
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}