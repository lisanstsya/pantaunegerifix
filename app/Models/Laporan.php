<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'judul', 'isi', 'media', 'waktu_laporan',
        'lokasi_detail', 'kecamatan', 'kelurahan', 'kabupaten',
        'kota', 'permintaan_solusi', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class);
    }
}
