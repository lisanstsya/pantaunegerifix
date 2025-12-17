<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tanggapan;
use App\Models\Laporan;
use Carbon\Carbon;

class TanggapanController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterWaktu = $request->input('filter_waktu');
        $kategori = $request->input('kategori'); 
        $today = Carbon::today();

        $query = Tanggapan::with('laporan.user', 'pemerintahProfile')
                    ->latest();

        // Search (berdasarkan laporan)
        if ($search) {
            $query->whereHas('laporan', function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('isi', 'like', "%$search%");
            });
        }

        // Filter kategori (ambil dari tabel laporan)
        if ($kategori) {
            $query->whereHas('laporan', function ($q) use ($kategori) {
                $q->where('kategori', $kategori);
            });
        }

        // Filter waktu tanggapan
        if ($filterWaktu) {
            switch ($filterWaktu) {
                case 'hari_ini':
                    $query->whereDate('created_at', $today);
                    break;

                case 'minggu_ini':
                    $query->whereBetween('created_at', [
                        $today->copy()->startOfWeek(),
                        $today->copy()->endOfWeek()
                    ]);
                    break;

                case 'bulan_ini':
                    $query->whereMonth('created_at', $today->month)
                          ->whereYear('created_at', $today->year);
                    break;

                case 'tahun_ini':
                    $query->whereYear('created_at', $today->year);
                    break;

                case 'tahun_lalu':
                    $query->whereYear('created_at', $today->year - 1);
                    break;
            }
        }

        $tanggapans = $query->paginate(8)->withQueryString();

        return view('tanggapan.index', compact('tanggapans'));
    }

    // ================================
    // Pemerintah lihat laporan baru
    // ================================
    public function pemerintahIndex(Request $request)
    {
        $search = $request->input('search');
        $filterWaktu = $request->input('filter_waktu');
        $kategori = $request->input('kategori');
        $today = Carbon::today();

        $query = Laporan::where('status', 'baru')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('isi', 'like', "%$search%");
            });
        }

        if ($filterWaktu) {
            switch ($filterWaktu) {
                case 'hari_ini':
                    $query->whereDate('created_at', $today);
                    break;

                case 'minggu_ini':
                    $query->whereBetween('created_at', [
                        $today->copy()->startOfWeek(),
                        $today->copy()->endOfWeek()
                    ]);
                    break;

                case 'bulan_ini':
                    $query->whereMonth('created_at', $today->month)
                          ->whereYear('created_at', $today->year);
                    break;

                case 'tahun_ini':
                    $query->whereYear('created_at', $today->year);
                    break;

                case 'tahun_lalu':
                    $query->whereYear('created_at', $today->year - 1);
                    break;
            }
        }


        // Filter kategori (ambil dari tabel laporan)
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $laporans = $query->paginate(8)->withQueryString();

        return view('pemerintah.tanggapan.index', compact('laporans', 'search'));
    }

    // ================================
    // Form buat tanggapan
    // ================================
    public function create(Laporan $laporan)
    {
        return view('pemerintah.tanggapan.create', compact('laporan'));
    }

    // ================================
    // Simpan tanggapan
    // ================================
    public function store(Request $request, Laporan $laporan)
    {
        $request->validate([
            'isi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_selesai' => 'required|date',
        ]);

        $fotoPath = $request->file('foto')?->store('tanggapan_foto', 'public');
        $user = auth()->user();

        Tanggapan::create([
            'laporan_id' => $laporan->id,
            'pemerintah_id' => $user->id,
            'isi' => $request->isi,
            'foto' => $fotoPath,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'selesai',
            'petugas' => $user->name ?? 'Admin',
            'jabatan' => $user->pemerintahProfile?->jabatan ?? '-',
        ]);

        $laporan->update(['status' => 'selesai']);

        return redirect()->route('tanggapan.pemerintah')
                         ->with('success', 'Tanggapan berhasil dibuat.');
    }

    // delete tanggapan
public function destroy(Tanggapan $tanggapan)
{
    $user = auth()->user();

    if ($user->role !== 'pemerintah' || $user->id !== $tanggapan->pemerintah_id) {
        abort(403, 'Akses ditolak.');
    }

    // Maks 3 hari
    if ($tanggapan->created_at->diffInDays(now()) > 3) {
        return redirect()->back()->with('error', 'Tanggapan hanya bisa dihapus maksimal 3 hari setelah dibuat.');
    }

    $laporan = $tanggapan->laporan;
    $tanggapan->delete();

    // kembalikan status laporan ke baru
    $laporan->update(['status' => 'baru']);

    return redirect()
        ->route('tanggapan.pemerintah')
        ->with('success', 'Tanggapan dihapus, laporan kembali ke status Baru.');
}


    // Form edit tanggapan
public function edit(Tanggapan $tanggapan)
{
    $user = auth()->user();

    // Hanya pemerintah yang punya tanggapan sendiri
    if ($user->role !== 'pemerintah' || $user->id !== $tanggapan->pemerintah_id) {
        abort(403, 'Akses ditolak.');
    }

    // Maks 3 hari sejak dibuat
    if ($tanggapan->created_at->diffInDays(now()) > 3) {
        return redirect()->back()->with('error', 'Tanggapan hanya bisa diubah maksimal 3 hari setelah dibuat.');
    }

    return view('pemerintah.tanggapan.edit', compact('tanggapan'));
}

// Update tanggapan
public function update(Request $request, Tanggapan $tanggapan)
{
    $user = auth()->user();
    if ($user->role !== 'pemerintah' || $user->id !== $tanggapan->pemerintah_id) {
        abort(403, 'Akses ditolak.');
    }

    // Maks 3 hari sejak dibuat
    if ($tanggapan->created_at->diffInDays(now()) > 3) {
        return redirect()->back()->with('error', 'Tanggapan hanya bisa diubah maksimal 3 hari setelah dibuat.');
    }

    $request->validate([
        'isi' => 'required|string',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'tanggal_selesai' => 'required|date',
    ]);

    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('tanggapan_foto', 'public');
        $tanggapan->foto = $fotoPath;
    }

    $tanggapan->isi = $request->isi;
    $tanggapan->tanggal_selesai = $request->tanggal_selesai;
    $tanggapan->save();

    return redirect()->route('laporan.show', $tanggapan->laporan_id)
                     ->with('success', 'Tanggapan berhasil diperbarui.');
}



}
