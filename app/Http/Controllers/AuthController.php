<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /* =========================================================
     *  PILIH ROLE
     * ========================================================= */
    public function pilihRole()
    {
        return view('auth.pilih-role');
    }

    public function pilihRoleProcess(Request $request)
    {
        $role = $request->role; // ambil role dari form GET

        if ($role === 'rt_rw') {
            return redirect()->route('login.rt_rw.form');
        }

        if ($role === 'pemerintah') {
            return redirect()->route('login.pemerintah.form');
        }

if ($role === 'masyarakat') {
    return redirect()->route('home'); // langsung ke halaman beranda publik
}


        return redirect()->route('auth.pilih-role')
                         ->with('error', 'Pilih role tidak valid.');
    }

    /* =========================================================
     *  LOGIN RT/RW
     * ========================================================= */
    public function loginRtRwForm()
    {
        return view('auth.login-rt-rw');
    }

    public function loginRtRw(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            if (Auth::user()->role !== 'rt_rw') {
                Auth::logout();
                return back()->with('error', 'Akun ini bukan akun RT/RW.');
            }

            session(['role' => 'rt_rw']);
            return redirect()->route('dashboard'); // dashboard utama
        }

        return back()->with('error', 'Email atau password salah');
    }

    /* =========================================================
     *  LOGIN PEMERINTAH
     * ========================================================= */
    public function loginPemerintahForm()
    {
        return view('auth.login-pemerintah');
    }

    public function loginPemerintah(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            if (Auth::user()->role !== 'pemerintah') {
                Auth::logout();
                return back()->with('error', 'Akun ini bukan akun Pemerintah.');
            }

            session(['role' => 'pemerintah']);
            return redirect()->route('dashboard'); // dashboard utama
        }

        return back()->with('error', 'Email atau password salah');
    }

    /* =========================================================
     *  REGISTER RT/RW
     * ========================================================= */
    public function registerRtRwForm()
    {
        return view('auth.register-rt-rw');
    }

    public function registerRtRw(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'jabatan'     => 'required|string|max:255',
            'rt'          => 'required|string|max:10',
            'rw'          => 'required|string|max:10',
            'provinsi'    => 'required|string|max:255',
            'kota'        => 'required|string|max:255',
            'kecamatan'   => 'required|string|max:255',
            'kelurahan'   => 'required|string|max:255',
            'no_hp'       => 'required|string|max:20',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6|confirmed',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'name', 'jabatan', 'rt', 'rw', 'provinsi', 'kota', 'kecamatan', 'kelurahan', 'no_hp', 'email'
        ]);

        $data['role'] = 'rt_rw';
        $data['password'] = bcrypt($request->password);

        // Upload foto profil jika ada
       if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('foto_rt_rw', $filename, 'public'); // pastikan 'public'
            $data['foto'] = $path;
        }



        User::create($data);

        return redirect()->route('login.rt_rw.form')
                        ->with('success', 'Registrasi RT/RW berhasil, silakan login.');
    }


    /* =========================================================
     *  REGISTER PEMERINTAH
     * ========================================================= */
    public function registerPemerintahForm()
    {
        return view('auth.register-pemerintah');
    }

public function registerPemerintah(Request $request)
{
    $request->validate([
        'name'          => 'required|string|max:255',
        'jabatan'       => 'required|string|max:255',
        'instansi'      => 'required|string|max:255',
        'kota'          => 'required|string|max:255',
        'provinsi'      => 'required|string|max:255',
        'no_hp'         => 'required|string|max:20',
        'email'         => 'required|email|unique:users,email',
        'password'      => 'required|string|confirmed|min:6',
        'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Upload foto profil
    $fotoPath = null;
    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $fotoPath = $file->storeAs('pemerintah', $filename, 'public');
    }

    // Simpan User
    $user = \App\Models\User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
        'role'     => 'pemerintah',
    ]);

    // Simpan Profile Pemerintah
    \App\Models\PemerintahProfile::create([
        'user_id' => $user->id,
        'nama'    => $request->name,
        'jabatan' => $request->jabatan,
        'instansi'=> $request->instansi,
        'kota'    => $request->kota,
        'provinsi'=> $request->provinsi,
        'no_hp'   => $request->no_hp,
        'foto'    => $fotoPath,
    ]);

    return redirect()->route('login.pemerintah.form')
                     ->with('success', 'Registrasi Pemerintah berhasil! Silakan login.');
}


    /* =========================================================
     *  LOGOUT
     * ========================================================= */
    public function logout()
    {
        Auth::logout();
        session()->flush();

        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }
}
