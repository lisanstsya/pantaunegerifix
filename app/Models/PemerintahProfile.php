<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Response;

class PemerintahProfile extends Model
{

    protected $fillable = [
        'user_id',
        'nama',
        'jabatan',
        'instansi',
        'provinsi',
        'kota',
        'no_hp',
        'foto'
    ];


    /**
     * Relasi ke user login
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke semua tanggapan yang dibuat pejabat ini
     */
    public function responses()
    {
        return $this->hasMany(Response::class, 'pemerintah_id');
    }

    /**
     * Accessor untuk URL foto profil
     */
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

}
