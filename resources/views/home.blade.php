@extends('layouts.app')

@push('styles')
<style>
    .card-wow {
        border-radius: 1.25rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: all .25s ease;
        overflow: hidden;
        background: #fff;
    }

    .card-wow:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(211,47,47,0.25);
    }

    .img-hover {
        transition: transform .35s ease;
    }

    .card-wow:hover .img-hover {
        transform: scale(1.05);
    }

    .badge-wow {
        padding: .45em .75em;
        font-weight: 600;
        border-radius: 999px;
        font-size: .75rem;
    }

    .section-divider {
        width: 80px;
        height: 4px;
        background: #d32f2f;
        border-radius: 4px;
        margin: 12px auto 0;
    }
</style>
@endpush

@section('content')

<!-- HERO -->
<div class="position-relative w-100" style="height:500px; overflow:hidden;">
    <div style="
        background-image: url('{{ asset('images/background.jpg') }}');
        background-size: cover;
        background-position: center;
        height: 100%;
        width: 100vw;
        position: absolute;
        inset: 0;
    "></div>

    <div style="
        position: absolute;
        inset: 0;
        background-color: rgba(0,0,0,0.45);
    "></div>

    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white position-relative h-100">
        <h1 class="display-3 fw-bold">
            Pantau Negeri
        </h1>
        <p class="lead fw-semibold fs-4">
            Untuk Indonesia yang Adil dan Transparan
        </p>

        @if(Auth::check() && session('role') === 'rt_rw')
            <a href="{{ route('lapor') }}" class="btn btn-danger btn-lg mt-3 px-4 shadow">
                <i class="bi bi-megaphone-fill me-1"></i> Buat Laporan Baru
            </a>
        @endif
    </div>
</div>

<section class="py-4 bg-white text-dark mt-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color:#d32f2f;">Tentang Pantau Negeri</h2>
            <p class="mx-auto text-dark" style="max-width:600px; font-size:1.1rem;">
                Pantau Negeri adalah platform digital untuk memudahkan masyarakat dalam melaporkan 
                isu-isu di suatu daerah yang membutuhkan perhatian pemerintah dengan perantara RT/RW kepada pemerintah agar lebih mudah untuk ditindaklanjuti.
            </p>
        </div>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm h-100">
                    <i class="bi bi-person-fill mb-3" style="font-size:2rem; color:#d32f2f;"></i>
                    <h5 class="fw-bold text-dark">Masyarakat</h5>
                    <p class="text-dark">Memantau progress pemerintah berdasarkan laporan yang telah dibuat.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm h-100">
                    <i class="bi bi-shield-fill-check mb-3" style="font-size:2rem; color:#d32f2f;"></i>
                    <h5 class="fw-bold text-dark">RT/RW</h5>
                    <p class="text-dark">Membuat laporan kepada pemerintah.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm h-100">
                    <i class="bi bi-building mb-3" style="font-size:2rem; color:#d32f2f;"></i>
                    <h5 class="fw-bold text-dark">Pemerintah</h5>
                    <p class="text-dark">Menanggapi laporan dan memberikan solusi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold text-danger">Dashboard Real Time</h2>
        <div class="section-divider"></div>

        <div class="row mt-4 g-4">
            @foreach([
                ['label'=>'Jumlah Laporan','value'=>$jumlahLaporan,'color'=>'primary'],
                ['label'=>'Jumlah Tanggapan','value'=>$jumlahTanggapan,'color'=>'success'],
                ['label'=>'Laporan Baru','value'=>$jumlahLaporanBaru,'color'=>'warning']
            ] as $stat)
            <div class="col-md-4">
                <div class="card card-wow py-4">
                    <h3 class="display-6 fw-bold text-{{ $stat['color'] }}">
                        {{ $stat['value'] }}
                    </h3>
                    <p class="text-muted mb-0">{{ $stat['label'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <h2 class="fw-bold text-danger text-center">4 Laporan Terbaru</h2>
        <div class="section-divider"></div>

        <div class="row mt-4 g-4">
            @forelse($laporanTerbaru as $laporan)
                @php
                    $rtRw = $laporan->user?->rtRwProfile;
                    $fotoPelapor = $rtRw && $rtRw->foto
                        ? asset('storage/'.$rtRw->foto)
                        : asset('images/default-avatar.png');
                @endphp

                <div class="col-md-3">
                    <a href="{{ route('laporan.show',$laporan->id) }}" class="text-decoration-none text-dark">
                        <div class="card card-wow h-100">
                            @if($laporan->media)
                                <img src="{{ asset('storage/'.$laporan->media) }}"
                                     class="img-hover"
                                     style="height:180px; object-fit:cover;">
                            @else
                                <div class="bg-light" style="height:180px;"></div>
                            @endif

                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ $fotoPelapor }}" class="rounded-circle me-2"
                                         width="32" height="32" style="object-fit:cover">
                                    <div class="small">
                                        <div class="fw-semibold">
                                            {{ $laporan->user?->name ?? '-' }}
                                        </div>
                                        <div class="text-muted">
                                            {{ $rtRw->provinsi ?? '-' }}
                                        </div>
                                    </div>
                                </div>

                                <h6 class="fw-bold">
                                    {{ Str::limit($laporan->judul,45) }}
                                </h6>

                                <p class="small text-muted">
                                    {{ Str::limit($laporan->isi,60) }}
                                </p>

                                <div class="d-flex justify-content-between">
                                    <span class="badge badge-wow
                                        {{ $laporan->status === 'baru' ? 'bg-warning text-dark' : 'bg-success' }}">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ \Carbon\Carbon::parse($laporan->waktu_laporan)->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="text-center text-muted">Belum ada laporan.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="fw-bold text-danger text-center">4 Tanggapan Terbaru</h2>
        <div class="section-divider"></div>

        <div class="row mt-4 g-4">
@forelse($tanggapanTerbaruAll->take(4) as $tanggapan)
    @if($tanggapan->laporan)
        @php
            $laporan = $tanggapan->laporan;
            $rtRw = $laporan->user?->rtRwProfile;
            $provinsiPelapor = $rtRw?->provinsi ?? '-';
            $pejabat = $tanggapan->pemerintahProfile;
            $fotoPejabat = $pejabat && $pejabat->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($pejabat->foto)
                ? asset('storage/'.$pejabat->foto)
                : asset('images/default-avatar.png');
            $jabatanPejabat = $pejabat?->jabatan ?? '-';
            $instansiPejabat = $pejabat?->instansi ?? '-';
            $provinsiPejabat = $pejabat?->provinsi ?? '-';
            $fotoPelapor = $rtRw && $rtRw->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($rtRw->foto)
                            ? asset('storage/'.$rtRw->foto)
                            : asset('images/default-avatar.png');
            $tanggalTanggapan = \Carbon\Carbon::parse($tanggapan->tanggal_selesai ?? $tanggapan->created_at)->format('d M Y');
        @endphp

        <div class="col-md-3">
            <a href="{{ route('laporan.show', $laporan->id) }}" class="text-decoration-none text-dark">
                <div class="card card-wow h-100">
                    {{-- Foto Tanggapan --}}
                    @if($tanggapan->foto)
                        <img src="{{ asset('storage/'.$tanggapan->foto) }}"
                             class="img-hover w-100"
                             style="height:180px; object-fit:cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height:180px;">
                            <span class="text-muted small">Tidak ada foto</span>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        {{-- Judul Laporan --}}
                        <h6 class="fw-bold mb-2" style="color:#000;">
                            {{ Str::limit($laporan->judul, 45) }}
                        </h6>

                        {{-- Deskripsi Tanggapan --}}
                        <p class="small text-muted mb-2">
                            {{ Str::limit($tanggapan->isi, 60) }}
                        </p>

                        {{-- Pelapor --}}
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ $fotoPelapor }}" class="rounded-circle me-2 border" width="32" height="32" style="object-fit:cover;">
                            <div class="small text-muted">{{ $laporan->user?->name ?? 'Anonim' }} | {{ $provinsiPelapor }}</div>
                        </div>

                        {{-- Pejabat --}}
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ $fotoPejabat }}" class="rounded-circle me-2 border" width="32" height="32" style="object-fit:cover;">
                            <div class="small text-muted">
                                {{ $jabatanPejabat }} | {{ $instansiPejabat }} | {{ $provinsiPejabat }}
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="mt-auto">
                            <small class="text-muted d-flex justify-content-end align-items-center">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $tanggalTanggapan }}
                            </small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif
@empty
    <div class="col-12 text-center text-muted">Belum ada tanggapan.</div>
@endforelse

        </div>
    </div>
</section>


@endsection
