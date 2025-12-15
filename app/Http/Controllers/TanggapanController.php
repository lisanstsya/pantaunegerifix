<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tanggapan;
use App\Models\Laporan;
use Carbon\Carbon;

class TanggapanController extends Controller
{
    // Semua tanggapan (umum)
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $filterWaktu = $request->input('filter_waktu');
        $today = Carbon::today();

        $query = Tanggapan::with('laporan.user', 'pemerintahProfile')
                    ->latest();

        if ($search) {
            $query->whereHas('laporan', function($q) use ($search){
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('isi', 'like', "%$search%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($filterWaktu) {
            switch($filterWaktu){
                case 'hari_ini':
                    $query->whereDate('created_at', $today);
                    break;
                case 'minggu_ini':
                    $query->whereBetween('created_at', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]);
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

    // Pemerintah lihat laporan baru
public function pemerintahIndex(Request $request)
{
    $search = $request->input('search');
    $filterWaktu = $request->input('filter_waktu');
    $today = Carbon::today();

    $query = Laporan::where('status', 'baru')->latest();

    if ($search) {
        $query->where(function($q) use ($search){
            $q->where('judul', 'like', "%$search%")
              ->orWhere('isi', 'like', "%$search%");
        });
    }

    if ($filterWaktu) {
        switch($filterWaktu){
            case 'hari_ini':
                $query->whereDate('created_at', $today);
                break;
            case 'minggu_ini':
                $query->whereBetween('created_at', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]);
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

    $laporans = $query->paginate(8)->withQueryString();

    return view('pemerintah.tanggapan.index', compact('laporans', 'search'));
}


    public function create(Laporan $laporan)
    {
        return view('pemerintah.tanggapan.create', compact('laporan'));
    }

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
            'status' => 'selesai', // otomatis selesai
            'petugas' => $user->name ?? 'Admin',
            'jabatan' => $user->pemerintahProfile?->jabatan ?? '-',
        ]);

        $laporan->update(['status' => 'selesai']); // update status laporan

        return redirect()->route('tanggapan.pemerintah')
                         ->with('success', 'Tanggapan berhasil dibuat.');
    }
}
