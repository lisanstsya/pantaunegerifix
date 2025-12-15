<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tanggapan;
use App\Models\PemerintahProfile;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggapan_id',
        'petugas',
        'jabatan',
        'komentar',
        'tanggal_selesai',
        'foto',
        'pemerintah_id',
    ];

    /**
     * Relasi ke Tanggapan
     */
    public function tanggapan()
    {
        return $this->belongsTo(Tanggapan::class, 'tanggapan_id');
    }

    /**
     * Relasi ke PemerintahProfile (pejabat yang memberi tanggapan)
     */
    public function pemerintah()
    {
        return $this->belongsTo(PemerintahProfile::class, 'pemerintah_id');
    }

    /**
     * Accessor untuk URL foto bukti
     */
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
