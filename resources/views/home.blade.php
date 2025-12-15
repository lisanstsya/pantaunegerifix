@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<div class="position-relative w-100" style="height:500px; overflow:hidden;">
    <div style="
        background-image: url('{{ asset('images/background.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100%;
        width: 100vw;
        position: absolute;
        top: 0;
        left: 0;
    "></div>

    <div style="
        position: absolute;
        top: 0; 
        left: 0;
        width: 100%; 
        height: 100%;
        background-color: rgba(0,0,0,0.4);
    "></div>

    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white position-relative h-100">
        <h1 class="display-3 fw-bold" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.6);">
            Pantau Negeri
        </h1>
        <p class="lead fw-semibold" style="font-size:1.5rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">
            Untuk Indonesia yang Adil dan Transparan
        </p>

        @if(Auth::check() && session('role') === 'rt_rw')
            <a href="{{ route('lapor') }}" class="btn btn-danger btn-lg mt-3 shadow-sm">
                Buat Laporan Baru
            </a>
        @endif
    </div>
</div>

<div class="my-4"></div>

<!-- Dashboard Statistik -->
<section class="py-5" style="background-color:#ffffff;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color:#d32f2f;">Dashboard Real Time</h2>
            <p class="text-muted">Memantau laporan dan tanggapan terbaru secara langsung</p>
        </div>

        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 py-4 px-3">
                    <h3 class="fw-bold display-6 text-primary">{{ $jumlahLaporan }}</h3>
                    <p class="mb-0 text-muted">Jumlah Laporan</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 py-4 px-3">
                    <h3 class="fw-bold display-6 text-success">{{ $jumlahTanggapan }}</h3>
                    <p class="mb-0 text-muted">Jumlah Tanggapan</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 py-4 px-3">
                    <h3 class="fw-bold display-6 text-warning">{{ $jumlahLaporanDitanggapi }}</h3>
                    <p class="mb-0 text-muted">Laporan Ditanggapi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4 Laporan Terbaru -->
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center" style="color:#d32f2f;">4 Laporan Terbaru</h2>
        <div class="row g-4">
            @forelse($laporanTerbaru as $laporan)
                <div class="col-md-3">
                    <a href="{{ route('laporan.show', $laporan->id) }}" class="text-decoration-none text-dark">
                        <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden" style="font-family: 'Inter', sans-serif; font-size:0.9rem;">
                            @if($laporan->media)
                                <img src="{{ asset('storage/'.$laporan->media) }}" class="card-img-top" style="height:180px; object-fit:cover;">
                            @else
                                <div class="bg-light" style="height:180px;"></div>
                            @endif
                            <div class="card-body">
                                <h6 class="fw-bold mb-2" style="min-height:20px;">{{ Str::limit($laporan->judul, 50) }}</h6>
                                <p class="small mb-2">{{ Str::limit($laporan->isi, 70) }}</p>

                                <div class="d-flex align-items-center mb-1">
                                    <span class="small fw-semibold">Pelapor:</span>
                                    <span class="ms-1">{{ $laporan->user?->name ?? '-' }}</span>
                                </div>
<span class="small fw-semibold">Tanggal:</span> {{ \Carbon\Carbon::parse($laporan->waktu_laporan)->format('d M Y') }}
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada laporan saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 4 Tanggapan Terbaru -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center" style="color:#d32f2f;">4 Tanggapan Terbaru</h2>
        <div class="row g-4">
            @forelse($tanggapanTerbaruAll as $tanggapan)
                @if($tanggapan->laporan)
                    <div class="col-md-3">
                        <a href="{{ route('laporan.show', $tanggapan->laporan_id) }}" class="text-decoration-none text-dark">
                            <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden" style="font-family: 'Inter', sans-serif; font-size:0.9rem;">
                                @if($tanggapan->foto)
                                    <img src="{{ asset('storage/'.$tanggapan->foto) }}" class="card-img-top" style="height:180px; object-fit:cover;">
                                @else
                                    <div class="bg-light" style="height:180px;"></div>
                                @endif
                                <div class="card-body">
                                    <h6 class="fw-bold mb-2" style="min-height:20px;">{{ Str::limit($tanggapan->laporan->judul, 50) }}</h6>
                                    <p class="text-secondary fst-italic mb-2" style="font-size:0.85rem;">{{ Str::limit($tanggapan->isi, 70) }}</p>

                                    <div class="d-flex align-items-center mb-1">
                                        <span class="small fw-semibold">Ditanggapi oleh:</span>
                                        <span class="ms-1">{{ $tanggapan->petugas ?? '-' }}</span>
                                    </div>

                                    <span class="small fw-semibold">Jabatan:</span> {{ $tanggapan->jabatan ?? '-' }}<br>
                                    <span class="small fw-semibold">Tanggal selesai:</span> {{ \Carbon\Carbon::parse($tanggapan->tanggal_selesai)->format('d M Y') }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada tanggapan saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
