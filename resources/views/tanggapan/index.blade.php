@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Judul Halaman --}}
    <h3 class="fw-bold text-center mb-4" style="color:#d32f2f;">Daftar Tanggapan</h3>

    {{-- Filter & Search --}}
    <form method="GET" class="row g-2 mb-4 justify-content-center">
        {{-- Search --}}
        <div class="col-md-3">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari tanggapan..." value="{{ request('search') }}">
        </div>

        {{-- Filter Waktu --}}
        <div class="col-md-2">
            <select name="filter_waktu" class="form-select">
                <option value="">Semua Waktu</option>
                <option value="hari_ini" {{ request('filter_waktu')=='hari_ini'?'selected':'' }}>Hari ini</option>
                <option value="minggu_ini" {{ request('filter_waktu')=='minggu_ini'?'selected':'' }}>Minggu ini</option>
                <option value="bulan_ini" {{ request('filter_waktu')=='bulan_ini'?'selected':'' }}>Bulan ini</option>
                <option value="tahun_ini" {{ request('filter_waktu')=='tahun_ini'?'selected':'' }}>Tahun ini</option>
                <option value="tahun_lalu" {{ request('filter_waktu')=='tahun_lalu'?'selected':'' }}>Tahun lalu</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-danger w-100">Terapkan</button>
        </div>
    </form>

    {{-- Card List --}}
    <div class="row g-3">
        @forelse($tanggapans as $tanggapan)
            @php
                $laporan = $tanggapan->laporan;
                $fotoPelapor = $laporan?->user?->rtRwProfile?->foto;
                $fotoPejabat = $tanggapan->pemerintahProfile?->foto;
                $fotoPelaporFullPath = $fotoPelapor ? 'public/'.$fotoPelapor : null;
                $fotoPejabatFullPath = $fotoPejabat ?? null;
            @endphp

            <div class="col-md-3 col-sm-6"> {{-- 4 kolom per row --}}
                <div class="card shadow-sm border-0 rounded-4 h-100 p-2">

                    {{-- Foto Tanggapan --}}
                    @if($tanggapan->foto)
                        <a href="{{ asset('storage/' . $tanggapan->foto) }}" target="_blank">
                            <img src="{{ asset('storage/' . $tanggapan->foto) }}" 
                                 class="img-fluid rounded-top mb-2" 
                                 style="width:100%; height:150px; object-fit:cover;">
                        </a>
                    @else
                        <div class="bg-light rounded-top mb-2" style="height:150px;"></div>
                    @endif

                    {{-- Judul Laporan --}}
                    <h6 class="fw-bold mb-2" style="font-size:0.95rem; min-height:40px; color:#d32f2f;">
                        {{ $laporan->judul ?? 'Laporan tidak ditemukan' }}
                    </h6>

                    {{-- Foto Pelapor dan Petugas --}}
                    <div class="mb-2">
                        <div class="d-flex align-items-center mb-1">
                            <img src="{{ $fotoPelaporFullPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPelaporFullPath) 
                                        ? asset('storage/'.$fotoPelaporFullPath) 
                                        : asset('images/default-avatar.png') }}" 
                                 class="rounded-circle me-2" 
                                 style="width:24px; height:24px; object-fit:cover;">
                            <span class="small fw-semibold">Pelapor:</span>
                            <span class="ms-1 small">{{ $laporan?->user?->name ?? 'Anonim' }}</span>
                        </div>

                        <div class="d-flex align-items-center">
                            <img src="{{ $fotoPejabatFullPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPejabatFullPath)
                                        ? asset('storage/'.$fotoPejabatFullPath) 
                                        : asset('images/default-avatar.png') }}" 
                                 class="rounded-circle me-2" 
                                 style="width:24px; height:24px; object-fit:cover;">
                            <span class="small fw-semibold">Petugas:</span>
                            <span class="ms-1 small">
                                {{ $tanggapan->pemerintah?->name ?? $tanggapan->petugas ?? '-' }}
                                ({{ $tanggapan->pemerintah?->jabatan ?? $tanggapan->jabatan ?? '-' }})
                            </span>
                        </div>
                    </div>

                    {{-- Isi Tanggapan --}}
                    <p class="text-secondary fst-italic small mb-2" style="-webkit-line-clamp:3; display:-webkit-box; -webkit-box-orient:vertical; overflow:hidden;">
                        "{{ $tanggapan->isi }}"
                    </p>

                    {{-- Footer --}}
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <a href="{{ route('laporan.show', $laporan?->id ?? 0) }}" class="btn btn-sm btn-danger">Lihat Laporan</a>
                        <small class="text-muted" style="font-size:0.75rem;">
                            {{ $tanggapan->tanggal_selesai ?? $tanggapan->created_at->format('d M Y') }}
                        </small>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted small">Belum ada tanggapan saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $tanggapans->withQueryString()->links() }}
    </div>

</div>
@endsection
