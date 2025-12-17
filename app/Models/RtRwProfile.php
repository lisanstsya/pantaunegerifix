<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RtRwProfile extends Model
{
    protected $table = 'rt_rw_profiles';

    protected $fillable = [
        'user_id', 'foto', 'nama', 'jabatan', 'rt', 'rw',
        'kecamatan', 'kelurahan', 'no_hp', 'kabupaten_kota', 'provinsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
