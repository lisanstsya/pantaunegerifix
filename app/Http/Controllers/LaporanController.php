<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Halaman daftar laporan publik dengan filter, search, dan pagination.
     */
    public function index(Request $request)
    {
        $query = Laporan::query();

        // Filter search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%")
                  ->orWhere('permintaan_solusi', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter waktu laporan
        $filterWaktu = $request->input('filter_waktu');
        $today = Carbon::today();

        if ($filterWaktu) {
            switch($filterWaktu) {
                case 'hari_ini':
                    $query->whereDate('waktu_laporan', $today);
                    break;
                case 'minggu_ini':
                    $query->whereBetween('waktu_laporan', [
                        $today->copy()->startOfWeek(),
                        $today->copy()->endOfWeek()
                    ]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('waktu_laporan', $today->month)
                          ->whereYear('waktu_laporan', $today->year);
                    break;
                case 'tahun_ini':
                    $query->whereYear('waktu_laporan', $today->year);
                    break;
                case 'tahun_lalu':
                    $query->whereYear('waktu_laporan', $today->year - 1);
                    break;
            }
        }

        // Pagination 8 per halaman (grid 4-4)
        $laporans = $query->latest()->paginate(8);

        return view('laporan.index', compact('laporans'));
    }

    /**
     * Form buat laporan baru
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Simpan laporan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:51200',
            'waktu_laporan' => 'required|date',
            'lokasi_detail' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'permintaan_solusi' => 'required|string',
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $filename = time().'_'.$file->getClientOriginalName();
            $mediaPath = $file->storeAs('laporan_media', $filename, 'public');
        }

        Laporan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
            'media' => $mediaPath,
            'waktu_laporan' => $request->waktu_laporan,
            'lokasi_detail' => $request->lokasi_detail,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'kabupaten' => $request->kabupaten,
            'kota' => $request->kota,
            'permintaan_solusi' => $request->permintaan_solusi,
            'status' => 'baru', // default baru
        ]);

        return redirect()->route('laporan')->with('success', 'Laporan berhasil dibuat!');
    }

    /**
     * Halaman detail laporan
     */
    public function show($id)
    {
        $laporan = Laporan::with('tanggapans.pemerintah')->findOrFail($id);
        return view('laporan.show', compact('laporan'));
    }

    /**
     * Hapus laporan (hanya untuk RT/RW)
     */
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        if (Auth::user()->role !== 'rt_rw') {
            abort(403, 'Unauthorized');
        }

        // Hapus file media jika ada
        if ($laporan->media && Storage::disk('public')->exists($laporan->media)) {
            Storage::disk('public')->delete($laporan->media);
        }

        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}
