<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Tanggapan;

class HomeController extends Controller
{
    public function index()
    {
        // 4 laporan terbaru
        $laporanTerbaru = Laporan::latest()->take(4)->get();

        // 4 tanggapan terbaru
        $tanggapanTerbaruAll = Tanggapan::latest()->take(4)->get();

        // Statistik untuk dashboard
        $jumlahLaporan = Laporan::count();
        $jumlahTanggapan = Tanggapan::count();
        $jumlahLaporanBaru = Laporan::where('status', 'baru')->count();
        
return view('home', compact(
    'laporanTerbaru', 
    'tanggapanTerbaruAll',
    'jumlahLaporan',
    'jumlahTanggapan',
    'jumlahLaporanBaru'
));

    }
}
