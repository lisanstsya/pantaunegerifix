@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold text-center mb-4" style="color:#d32f2f;">
        Laporan Masyarakat Terbaru
    </h3>

    <form method="GET" class="d-flex flex-wrap gap-2 justify-content-center mb-4">

        <input type="text" name="search" class="form-control" style="width:220px"
               placeholder="Cari laporan..." value="{{ request('search') }}">

        <select name="status" class="form-select" style="width:160px">
            <option value="">Semua Status</option>
            <option value="baru" @selected(request('status')=='baru')>Baru</option>
            <option value="selesai" @selected(request('status')=='selesai')>Selesai</option>
        </select>

        <select name="kategori" class="form-select" style="width:180px">
            <option value="">Semua Kategori</option>
            @foreach(['Infrastruktur','Kebersihan','Keamanan','Pelayanan Publik','Lingkungan','Lainnya'] as $kat)
                <option value="{{ $kat }}" @selected(request('kategori')==$kat)>
                    {{ $kat }}
                </option>
            @endforeach
        </select>

        <select name="filter_waktu" class="form-select" style="width:160px">
            <option value="">Semua Waktu</option>
            <option value="hari_ini">Hari ini</option>
            <option value="minggu_ini">Minggu ini</option>
            <option value="bulan_ini">Bulan ini</option>
            <option value="tahun_ini">Tahun ini</option>
            <option value="tahun_lalu">Tahun lalu</option>
        </select>

        <button class="btn btn-danger px-4">Terapkan</button>
    </form>

    <div class="row g-3">
        @forelse($laporans as $laporan)

            @php
                $rtRw = $laporan->user?->rtRwProfile;

                if (
                    $rtRw &&
                    $rtRw->foto &&
                    \Illuminate\Support\Facades\Storage::disk('public')->exists($rtRw->foto)
                ) {
                    $fotoPelapor = asset('storage/'.$rtRw->foto);
                } else {
                    $fotoPelapor = asset('images/default-avatar.png');
                }
            @endphp

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm border-0 rounded-4 h-100 d-flex flex-column">

                    {{-- Foto Laporan --}}
                    @if($laporan->media)
                        <img src="{{ asset('storage/'.$laporan->media) }}"
                             class="img-fluid rounded-top"
                             style="height:150px; object-fit:cover;">
                    @else
                        <div class="bg-light rounded-top" style="height:150px;"></div>
                    @endif

                    <div class="card-body d-flex flex-column p-2">

                        {{-- Badge Status --}}
                        <div class="mb-2">
                            <span class="badge {{ $laporan->status === 'baru'
                                ? 'bg-warning text-dark'
                                : 'bg-success' }}">
                                {{ ucfirst($laporan->status) }}
                            </span>
                        </div>

                        {{-- Pelapor --}}
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ $fotoPelapor }}"
                                 class="rounded-circle me-2 border"
                                 width="32" height="32"
                                 style="object-fit:cover;">

                            <div class="small">
                                <div class="fw-semibold">
                                    {{ $laporan->user?->name ?? 'Anonim' }}
                                </div>
                                        <div class="text-muted">
                                            {{ $rtRw->provinsi ?? '-' }}
                                        </div>
                            </div>
                        </div>

                        {{-- Judul --}}
                        <h6 class="fw-bold mb-1" style="font-size:0.95rem;">
                            {{ $laporan->judul }}
                        </h6>

                        {{-- Kategori --}}
                        <small class="mb-1">
                            Kategori: {{ $laporan->kategori }}
                        </small>

                        {{-- Tanggal --}}
                        <small class="text-muted mb-1">
                            {{ \Carbon\Carbon::parse($laporan->waktu_laporan)->format('d M Y') }}
                        </small>

                        {{-- Deskripsi --}}
                        <p class="text-secondary small mb-2"
                           style="-webkit-line-clamp:3; display:-webkit-box; -webkit-box-orient:vertical; overflow:hidden;">
                            {{ \Illuminate\Support\Str::limit($laporan->isi, 80) }}
                        </p>

                        {{-- Preview Tanggapan --}}
                        @if($laporan->tanggapans->count())
                            <div class="border-start border-3 border-danger ps-2 mt-auto mb-2">
                                <small class="text-danger fw-bold">
                                    Tanggapan Pemerintah
                                </small>
                                <p class="small mb-0">
                                    {{ \Illuminate\Support\Str::limit($laporan->tanggapans->first()->isi, 80) }}
                                </p>
                            </div>
                        @endif

                        {{-- Button --}}
                        <a href="{{ route('laporan.show', $laporan->id) }}"
                           class="btn btn-sm btn-danger w-100 mt-auto">
                            Lihat Detail
                        </a>

                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada laporan saat ini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $laporans->withQueryString()->links() }}
    </div>

</div>
@endsection
