@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Judul Halaman --}}
    <h3 class="fw-bold text-center mb-4" style="color:#d32f2f;">Laporan Masyarakat Terbaru</h3>

    {{-- Filter & Search --}}
    <form method="GET" class="row g-2 mb-4 justify-content-center">

        {{-- Search --}}
        <div class="col-md-3">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari laporan..." value="{{ request('search') }}">
        </div>

        {{-- Status --}}
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="baru" {{ request('status')=='baru'?'selected':'' }}>Baru</option>
                <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
            </select>
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
                <div class="card shadow-sm border-0 rounded-4 h-100 d-flex flex-column">

                    {{-- Foto --}}
                    @if($laporan->media)
                        <img src="{{ asset('storage/'.$laporan->media) }}"
                             class="img-fluid rounded-top mb-2"
                             style="width:100%; height:150px; object-fit:cover;">
                    @else
                        <div class="bg-light rounded-top mb-2" style="height:150px;"></div>
                    @endif

                    <div class="card-body d-flex flex-column p-2">

                        {{-- Badge Status --}}
                        <div class="mb-2">
                            <span class="badge bg-primary">{{ ucfirst($laporan->status) }}</span>
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

                        {{-- Tanggapan Preview --}}
                        @if($laporan->tanggapans->count())
                            <div class="border-start border-3 border-danger ps-2 mt-auto mb-2">
                                <small class="text-danger fw-bold">Tanggapan Pemerintah:</small>
                                <p class="small mb-0">{{ Str::limit($laporan->tanggapans->first()->isi, 90) }}</p>
                            </div>
                        @endif

                        {{-- Footer / Button --}}
                        <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-danger w-100 mt-auto">
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

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $laporans->withQueryString()->links() }}
    </div>

</div>
@endsection
