<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'pemerintah_id',
        'isi',
        'foto',
        'tanggal_selesai',
        'status',
        'petugas',
        'jabatan'
    ];

protected $casts = [
    'tanggal_selesai' => 'datetime',
];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function pemerintah()
    {
        return $this->belongsTo(User::class, 'pemerintah_id');
    }

    public function pemerintahProfile()
    {
        return $this->belongsTo(\App\Models\PemerintahProfile::class, 'pemerintah_id', 'user_id');
    }

    
}
