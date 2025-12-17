@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold text-center mb-4 text-danger">Daftar Tanggapan</h3>

    <form method="GET" class="d-flex flex-wrap gap-2 justify-content-center mb-4">

        <input type="text" name="search" class="form-control" style="width:220px"
               placeholder="Cari tanggapan..." value="{{ request('search') }}">

        <select name="kategori" class="form-select" style="width:180px">
            <option value="">Semua Kategori</option>
            @foreach(['Infrastruktur','Kebersihan','Keamanan','Pelayanan Publik','Lingkungan','Lainnya'] as $kat)
                <option value="{{ $kat }}" @selected(request('kategori')==$kat)>{{ $kat }}</option>
            @endforeach
        </select>

        <select name="filter_waktu" class="form-select" style="width:160px">
            <option value="">Semua Waktu</option>
            <option value="hari_ini" @selected(request('filter_waktu')=='hari_ini')>Hari ini</option>
            <option value="minggu_ini" @selected(request('filter_waktu')=='minggu_ini')>Minggu ini</option>
            <option value="bulan_ini" @selected(request('filter_waktu')=='bulan_ini')>Bulan ini</option>
            <option value="tahun_ini" @selected(request('filter_waktu')=='tahun_ini')>Tahun ini</option>
            <option value="tahun_lalu" @selected(request('filter_waktu')=='tahun_lalu')>Tahun lalu</option>
        </select>

        <button class="btn btn-danger px-4">Terapkan</button>
    </form>

    <div class="row g-3">
        @forelse($tanggapans->take(8) as $tanggapan)
            @php
                $laporan = $tanggapan->laporan;
                $rtRw = $laporan?->user?->rtRwProfile;

                // Foto pelapor
                $fotoPelapor = $rtRw && $rtRw->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($rtRw->foto)
                                ? asset('storage/'.$rtRw->foto)
                                : asset('images/default-avatar.png');

                // Foto pejabat
                $pemerintah = $tanggapan->pemerintahProfile;
                $fotoPejabat = $pemerintah && $pemerintah->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($pemerintah->foto)
                               ? asset('storage/'.$pemerintah->foto)
                               : asset('images/default-avatar.png');

                $tanggalTanggapan = \Carbon\Carbon::parse($tanggapan->tanggal_selesai ?? $tanggapan->created_at)->format('d M Y');

                // Data pelapor & pejabat
                $provinsiPelapor = $rtRw?->provinsi ?? '-';
                $jabatanPejabat = $pemerintah?->jabatan ?? '-';
                $instansiPejabat = $pemerintah?->instansi ?? '-';
                $provinsiPejabat = $pemerintah?->provinsi ?? '-';
            @endphp

 <div class="col-lg-3 col-md-6 col-sm-12 d-flex">
    <div class="card shadow-sm border-0 rounded-4 flex-fill d-flex flex-column overflow-hidden">

        <div class="overflow-hidden" style="height:180px;">
            @if($tanggapan->foto)
                <a href="{{ asset('storage/' . $tanggapan->foto) }}" target="_blank">
                    <img src="{{ asset('storage/' . $tanggapan->foto) }}" 
                         class="img-fluid w-100 h-100" 
                         style="object-fit:cover;">
                </a>
            @else
                <div class="bg-light w-100 h-100"></div>
            @endif
        </div>

        <div class="card-body d-flex flex-column p-3">

            <h6 class="fw-bold mb-1" style="font-size:0.95rem;">
                {{ $laporan->judul ?? 'Laporan tidak ditemukan' }}
            </h6>

            <p class="text-secondary small mb-2"
               style="-webkit-line-clamp:3; display:-webkit-box; -webkit-box-orient:vertical; overflow:hidden;">
                "{{ $tanggapan->isi }}"
            </p>

            <div class="d-flex align-items-center mb-2">
                <img src="{{ $fotoPelapor }}" class="rounded-circle me-2 border" width="32" height="32" style="object-fit:cover;">
                <div class="small text-muted">
                    {{ $laporan->user?->name ?? 'Anonim' }} | {{ $provinsiPelapor }}
                </div>
            </div>

            <div class="d-flex align-items-center mb-3">
                <img src="{{ $fotoPejabat }}" class="rounded-circle me-2 border" width="32" height="32" style="object-fit:cover;">
                <div class="small text-muted">
                    {{ $jabatanPejabat }} | {{ $instansiPejabat }} | {{ $provinsiPejabat }}
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-auto">
                <a href="{{ route('laporan.show', $laporan?->id ?? 0) }}" 
                   class="btn btn-sm btn-danger">
                    Lihat Laporan
                </a>
                <small class="text-muted d-flex align-items-center">
                    <i class="bi bi-calendar-event me-1"></i>
                    {{ $tanggalTanggapan }}
                </small>
            </div>

        </div>
    </div>
</div>

        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada tanggapan saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $tanggapans->withQueryString()->links() }}
    </div>

</div>
@endsection
