<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemerintahProfile;
use App\Models\Laporan;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;

class PemerintahController extends Controller
{
    /**
     * Form registrasi / login pemerintah
     */
    public function registerForm()
    {
        return view('pemerintah.register');
    }

    /**
     * Proses simpan data pemerintah
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pemerintah', // pastikan kolom ada dan fillable
        ]);

        \Auth::login($user);

        $fotoPath = $request->hasFile('foto') 
            ? $request->file('foto')->store('pemerintah', 'public') 
            : null;

        \App\Models\PemerintahProfile::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'instansi' => $request->instansi,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'no_hp' => $request->no_hp,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('login.pemerintah.form')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Daftar semua laporan untuk ditanggapi
     */
public function laporan(Request $request)
{
    $laporans = Laporan::with('user')
        ->whereIn('status', ['baru', 'diproses']) // 🔥 INI KUNCINYA
        ->when($request->search, function ($q) use ($request) {
            $q->where('judul', 'like', '%'.$request->search.'%')
              ->orWhere('isi', 'like', '%'.$request->search.'%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(8);

    return view('pemerintah.laporan', compact('laporans'));
}


    /**
     * Form tanggapan untuk laporan tertentu
     */
    public function tanggapiLaporan($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('pemerintah.tanggap', compact('laporan'));
    }

    /**
     * Proses simpan tanggapan
     */
    public function storeTanggapan(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

$data = $request->validate([
    'komentar' => 'required|string',
    'tanggal_selesai' => 'nullable|date|before_or_equal:today',
    'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('responses', 'public');
        }

        $data['laporan_id'] = $laporan->id;
        $data['pemerintah_id'] = Auth::id();

        Response::create($data);

        return redirect()->route('pemerintah.laporan')
            ->with('success', 'Tanggapan berhasil dikirim!');
    }
}
