<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'lokasi_masuk',
        'lokasi_keluar',
        'type',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
