<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Tampilkan daftar laporan
    public function index(Request $request)
    {
        $query = Laporan::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%")
                  ->orWhere('permintaan_solusi', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) $query->where('status', $status);
        if ($kategori = $request->input('kategori')) $query->where('kategori', $kategori);

        $filterWaktu = $request->input('filter_waktu');
        $today = Carbon::today();
        if ($filterWaktu) {
            switch($filterWaktu) {
                case 'hari_ini':
                    $query->whereDate('tanggal_kejadian', $today);
                    break;
                case 'minggu_ini':
                    $query->whereBetween('tanggal_kejadian', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('tanggal_kejadian', $today->month)->whereYear('tanggal_kejadian', $today->year);
                    break;
                case 'tahun_ini':
                    $query->whereYear('tanggal_kejadian', $today->year);
                    break;
                case 'tahun_lalu':
                    $query->whereYear('tanggal_kejadian', $today->year - 1);
                    break;
            }
        }

        $laporans = $query->latest()->paginate(8);
        return view('laporan.index', compact('laporans'));
    }

    // Tampilkan form buat laporan
    public function create()
    {
        return view('laporan.create');
    }

    // Simpan laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'media' => 'required|file|mimes:jpg,jpeg,png,mp4,mov|max:51200',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'lokasi_detail' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:255',
            'permintaan_solusi' => 'required|string',
        ]);

        $mediaPath = $request->hasFile('media') 
            ? $request->file('media')->store('laporan_media', 'public') 
            : null;

        Laporan::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'lokasi_detail' => $request->lokasi_detail,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'permintaan_solusi' => $request->permintaan_solusi,
            'media' => $mediaPath,
            'status' => 'baru',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('laporan')->with('success','Laporan berhasil dibuat!');
    }

    // Tampilkan detail laporan
    public function show($id)
    {
        $laporan = Laporan::with('tanggapans.pemerintah')->findOrFail($id);
        return view('laporan.show', compact('laporan'));
    }

    // Edit laporan (max 3 hari)
    public function edit(Laporan $laporan)
    {
        if (Auth::id() !== $laporan->user_id || now()->diffInHours($laporan->created_at) > 72) {
            abort(403, 'Tidak bisa mengedit laporan ini.');
        }
        return view('laporan.edit', compact('laporan'));
    }

    // Update laporan
    public function update(Request $request, Laporan $laporan)
    {
        if (Auth::id() !== $laporan->user_id || now()->diffInHours($laporan->created_at) > 72) {
            abort(403, 'Tidak bisa mengupdate laporan ini.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:51200',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'lokasi_detail' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:255',
            'permintaan_solusi' => 'required|string',
        ]);

        $mediaPath = $laporan->media;
        if ($request->hasFile('media')) {
            if ($laporan->media) Storage::disk('public')->delete($laporan->media);
            $mediaPath = $request->file('media')->store('laporan_media', 'public');
        }

        $laporan->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'lokasi_detail' => $request->lokasi_detail,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'permintaan_solusi' => $request->permintaan_solusi,
            'media' => $mediaPath,
        ]);

        return redirect()->route('laporan.show', $laporan)->with('success', 'Laporan berhasil diperbarui.');
    }

    // Hapus laporan
    public function destroy(Laporan $laporan)
    {
        if (Auth::id() !== $laporan->user_id || now()->diffInHours($laporan->created_at) > 72) {
            abort(403, 'Tidak bisa menghapus laporan ini.');
        }

        if ($laporan->media) Storage::disk('public')->delete($laporan->media);
        $laporan->delete();

        return redirect()->route('laporan')->with('success', 'Laporan berhasil dihapus.');
    }
}
