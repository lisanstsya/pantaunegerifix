@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Judul Halaman --}}
    <h3 class="fw-bold text-center mb-4" style="color:#d32f2f;">
        Laporan Menunggu Tanggapan
    </h3>

    {{-- Filter & Search --}}
    <form method="GET" class="row g-2 mb-4 justify-content-center">

        {{-- Search --}}
        <div class="col-md-3">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari laporan..." value="{{ request('search') }}">
        </div>

        {{-- Waktu Laporan --}}
        <div class="col-md-2">
            <select name="filter_waktu" class="form-select">
                <option value="">Semua Waktu</option>
                <option value="hari_ini" {{ request('filter_waktu')=='hari_ini'?'selected':'' }}>Hari ini</option>
                <option value="minggu_ini" {{ request('filter_waktu')=='minggu_ini'?'selected':'' }}>Minggu ini</option>
                <option value="bulan_ini" {{ request('filter_waktu')=='bulan_ini'?'selected':'' }}>Bulan ini</option>
                <option value="tahun_ini" {{ request('filter_waktu')=='tahun_ini'?'selected':'' }}>Tahun ini</option>
                <option value="tahun_lalu" {{ request('filter_waktu')=='tahun_lalu'?'selected':'' }}>Tahun sebelumnya</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-danger w-100">Terapkan</button>
        </div>
    </form>

    {{-- Card List --}}
    <div class="row g-3">
        @forelse($laporans as $laporan)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm border-0 rounded-4 h-100 p-2 d-flex flex-column">

                    {{-- Foto --}}
                    @if($laporan->media)
                        <img src="{{ asset('storage/'.$laporan->media) }}"
                             class="img-fluid rounded-top mb-2"
                             style="width:100%; height:150px; object-fit:cover;">
                    @else
                        <div class="bg-light rounded-top mb-2" style="height:150px;"></div>
                    @endif

                    {{-- Badge Status --}}
                    <div class="mb-2">
                        <span class="badge bg-warning text-dark">Baru</span>
                    </div>

                    {{-- Judul --}}
                    <h6 class="fw-bold mb-2" style="font-size:0.95rem; min-height:40px;">
                        {{ $laporan->judul }}
                    </h6>

                    {{-- Tanggal --}}
                    <small class="d-block mb-1" style="font-size:0.8rem;">
                        Tanggal: {{ \Carbon\Carbon::parse($laporan->waktu_laporan)->format('d M Y') }}
                    </small>

                    {{-- Lokasi --}}
                    <small class="text-muted d-block mb-2" style="font-size:0.8rem;">
                        Lokasi: {{ $laporan->lokasi_detail }}, {{ $laporan->kabupaten }}, {{ $laporan->provinsi ?? '-' }}
                    </small>

                    {{-- Deskripsi --}}
                    <p class="text-secondary small mb-2" style="-webkit-line-clamp:3; display:-webkit-box; -webkit-box-orient:vertical; overflow:hidden;">
                        {{ Str::limit($laporan->isi, 80) }}
                    </p>

                    {{-- Pelapor --}}
                    <div class="d-flex align-items-center mb-2">
                        @php
                            $fotoPelapor = $laporan->user?->rtRwProfile?->foto;
                            $fotoPelaporPath = $fotoPelapor ? 'public/'.$fotoPelapor : null;
                        @endphp
                        <img src="{{ $fotoPelaporPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPelaporPath)
                                    ? asset('storage/'.$fotoPelaporPath)
                                    : asset('images/default-avatar.png') }}"
                             class="rounded-circle me-2"
                             style="width:28px; height:28px; object-fit:cover;">
                        <small class="text-muted">{{ $laporan->user?->name ?? 'Anonim' }}</small>
                    </div>

                    {{-- Footer / Button --}}
                    <a href="{{ route('tanggap.create', $laporan->id) }}" 
                       class="btn btn-sm btn-danger mt-auto w-100">
                       Tanggapi
                    </a>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada laporan pending 🎉</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $laporans->withQueryString()->links() }}
    </div>

</div>
@endsection
