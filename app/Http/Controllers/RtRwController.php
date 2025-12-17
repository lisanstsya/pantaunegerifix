<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RtRwProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RtRwController extends Controller
{
    // TAMPILAN FORM REGISTER
    public function registerForm()
    {
        return view('auth.create-profile-rt-rw');
    }

    // PROSES MENYIMPAN DATA REGISTER + PROFILE
    public function storeProfile(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama'            => 'required|string',
            'jabatan'         => 'required|string',
            'rt'              => 'required|integer',
            'rw'              => 'required|integer',
            'provinsi'        => 'required|string',
            'kabupaten_kota'  => 'required|string',
            'kecamatan'       => 'required|string',
            'kelurahan'       => 'required|string',
            'no_hp'           => 'required|string',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|confirmed|min:6',
            'foto'            => 'required|image|max:2048',
        ]);

        /**
         * ===============================
         * SIMPAN FOTO RT/RW (BENAR)
         * ===============================
         * Lokasi fisik:
         * storage/app/public/foto_rt_rw
         *
         * Isi DB:
         * foto_rt_rw/namafile.jpg
         */
        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')
                ->store('foto_rt_rw', 'public');
        }

        // SIMPAN USER
        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'rt_rw',
            'no_hp'    => $request->no_hp,
        ]);

        // SIMPAN PROFILE RT/RW
        RtRwProfile::create([
            'user_id'         => $user->id,
            'nama'            => $request->nama,
            'jabatan'         => $request->jabatan,
            'rt'              => $request->rt,
            'rw'              => $request->rw,
            'provinsi'        => $request->provinsi,
            'kabupaten_kota'  => $request->kabupaten_kota,
            'kecamatan'       => $request->kecamatan,
            'kelurahan'       => $request->kelurahan,
            'no_hp'           => $request->no_hp,
            'foto'            => $fotoPath,
        ]);

        return redirect()->route('login.rt_rw.form')
            ->with('success', 'Registrasi RT/RW berhasil, silakan login.');
    }
}
