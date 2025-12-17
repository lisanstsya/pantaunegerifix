@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Judul Halaman --}}
    <h3 class="fw-bold text-center mb-4" style="color:#d32f2f;">
        Detail Laporan
    </h3>

    {{-- ================== LAPORAN ================== --}}
    <div class="card shadow-sm mb-4 border-danger">
        @if($laporan->media)
            <a href="{{ asset('storage/'.$laporan->media) }}" target="_blank">
                <img src="{{ asset('storage/'.$laporan->media) }}"
                     class="img-fluid rounded-top"
                     style="width:100%; max-height:450px; object-fit:cover;">
            </a>
        @endif

        <div class="card-body">
            <h3 class="fw-bold mb-4">{{ $laporan->judul }}</h3>

            @php
                use Illuminate\Support\Facades\Storage;
                $rtRw = $laporan->user?->rtRwProfile;
                $fotoPelaporUrl = ($rtRw && $rtRw->foto && Storage::disk('public')->exists($rtRw->foto))
                                  ? asset('storage/'.$rtRw->foto)
                                  : asset('images/default-avatar.png');
                $tanggalLaporan = \Carbon\Carbon::parse($laporan->created_at)->format('d M Y');
                $tanggalKejadian = \Carbon\Carbon::parse($laporan->tanggal_kejadian)->format('d M Y');
                $canModifyLaporan = auth()->check() &&
                                    auth()->user()->role === 'rt_rw' &&
                                    auth()->user()->id === $laporan->user_id &&
                                    now()->diffInHours($laporan->created_at) <= 72;
            @endphp

            <div class="d-flex align-items-center mb-3 border rounded p-2 bg-light">
                <img src="{{ $fotoPelaporUrl }}" class="rounded-circle border me-3"
                     style="width:55px; height:55px; object-fit:cover;">
                <div style="font-size:0.9rem;">
                    <div class="fw-bold">{{ $laporan->user?->name ?? 'Anonim' }}</div>
                    <div class="text-muted">
                        {{ $rtRw?->jabatan }}, RT {{ $rtRw?->rt ?? '-' }}, RW {{ $rtRw?->rw ?? '-' }}, {{ $laporan->lokasi_detail }},
                        {{ $laporan?->kelurahan ?? '-' }}, {{ $laporan?->kecamatan ?? '-' }},
                        {{ $laporan?->kabupaten_kota ?? '-' }}, {{ $rtRw?->provinsi ?? '-' }}
                    </div>
                    <div class="text-muted">
                        Tanggal Kejadian: {{ $tanggalKejadian }} | Tanggal Laporan Dibuat: {{ $tanggalLaporan }}
                    </div>
                </div>
            </div>

            <hr>

            <p><strong>Kategori:</strong> {{ $laporan->kategori }}</p>
            <p><strong>Deskripsi:</strong><br>{{ $laporan->isi }}</p>
            @if($laporan->permintaan_solusi)
                <p><strong>Permintaan Solusi:</strong><br>{{ $laporan->permintaan_solusi }}</p>
            @endif

            @if($canModifyLaporan)
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST"
                          onsubmit="return confirm('Hapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </div>
            @endif

            @if(auth()->check() && auth()->user()->role === 'pemerintah')
                <button type="button" class="btn btn-sm btn-outline-danger mt-3" data-bs-toggle="modal" data-bs-target="#pelaporModal-laporan">
                    Lihat Detail Pelapor
                </button>
            @endif
        </div>
    </div>

    {{-- ================== TANGGAPAN ================== --}}
    <h4 class="mb-3">Tanggapan</h4>

    @forelse($laporan->tanggapans as $tanggapan)
        @php
            $pejabat = $tanggapan->pemerintahProfile;
            $fotoPejabatUrl = ($pejabat && $pejabat->foto && Storage::disk('public')->exists($pejabat->foto))
                              ? asset('storage/'.$pejabat->foto)
                              : asset('images/default-avatar.png');
            $tanggalDibuat = \Carbon\Carbon::parse($tanggapan->created_at)->format('d M Y');
            $tanggalSelesai = $tanggapan->tanggal_selesai
                              ? \Carbon\Carbon::parse($tanggapan->tanggal_selesai)->format('d M Y')
                              : '-';
            $canModifyTanggapan = auth()->check() &&
                                  auth()->user()->role === 'pemerintah' &&
                                  auth()->user()->id === $tanggapan->pemerintah_id &&
                                  now()->diffInHours($tanggapan->created_at) <= 72;
        @endphp

        <div class="card mb-3 shadow-sm border-success">
            <div class="card-body bg-white">
                <div class="d-flex align-items-center mb-2 border-bottom pb-2">
                    <img src="{{ $fotoPejabatUrl }}" class="rounded-circle border me-3"
                         style="width:55px; height:55px; object-fit:cover;">
                    <div>
                        <div class="fw-bold">{{ $tanggapan->pemerintah?->name ?? $tanggapan->petugas }}</div>
                        <div class="text-muted" style="font-size:0.85rem;">
                            {{ $tanggapan->jabatan ?? '-' }} | {{ $pejabat?->instansi ?? '-' }} | {{ $pejabat?->provinsi ?? '-' }}<br>
                            Dibuat: {{ $tanggalDibuat }} | Ditindaklanjuti: {{ $tanggalSelesai }}
                        </div>
                    </div>
                </div>

                <p class="fst-italic text-secondary mt-2">
                    "{{ $tanggapan->isi }}"
                </p>

                @if($tanggapan->foto && Storage::disk('public')->exists($tanggapan->foto))
                    <strong>Dokumentasi Tindak Lanjut:</strong>
                    <a href="{{ asset('storage/'.$tanggapan->foto) }}" target="_blank">
                        <img src="{{ asset('storage/'.$tanggapan->foto) }}" class="img-fluid rounded w-100 mt-2" style="max-height:450px; object-fit:cover;">
                    </a>
                @endif

                @if($canModifyTanggapan)
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('tanggapan.edit', $tanggapan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('tanggapan.destroy', $tanggapan->id) }}" method="POST"
                              onsubmit="return confirm('Hapus tanggapan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                @endif

                @if(auth()->check() && auth()->user()->role === 'rt_rw')
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#pemerintahModal-{{ $tanggapan->id }}">
                        Lihat Detail Pemerintah
                    </button>
                @endif
            </div>
        </div>
    @empty
        <p>Belum ada tanggapan.</p>
    @endforelse

    {{-- ================== MODAL ================== --}}
    @if(auth()->check() && auth()->user()->role === 'pemerintah')
        <div class="modal fade" id="pelaporModal-laporan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Detail Pelapor</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ $fotoPelaporUrl }}" class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
                        <h6 class="fw-bold">{{ $laporan->user?->name ?? 'Anonim' }}</h6>
                        <p class="mb-1">{{ $rtRw?->jabatan }}, RT {{ $rtRw?->rt ?? '-' }}, RW {{ $rtRw?->rw ?? '-' }}</p>
                        <p class="mb-1">{{ $rtRw?->kelurahan ?? '-' }}, {{ $rtRw?->kecamatan ?? '-' }}</p>
                        <p class="mb-1">{{ $rtRw?->kabupaten_kota ?? '-' }}, {{ $rtRw?->provinsi ?? '-' }}</p>
                        <p class="mb-1">No HP: {{ $laporan->user?->no_hp ?? '-' }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @foreach($laporan->tanggapans as $tanggapan)
        @if(auth()->check() && auth()->user()->role === 'rt_rw')
            <div class="modal fade" id="pemerintahModal-{{ $tanggapan->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-success">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">Detail Pemerintah</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ $tanggapan->pemerintahProfile && $tanggapan->pemerintahProfile->foto && Storage::disk('public')->exists($tanggapan->pemerintahProfile->foto) ? asset('storage/'.$tanggapan->pemerintahProfile->foto) : asset('images/default-avatar.png') }}" class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
                            <h6 class="fw-bold">{{ $tanggapan->pemerintah?->name ?? $tanggapan->petugas }}</h6>
                            <p class="mb-1">{{ $tanggapan->jabatan ?? '-' }} | {{ $tanggapan->pemerintahProfile?->instansi ?? '-' }}</p>
                            <p class="mb-1">{{ $tanggapan->pemerintahProfile?->provinsi ?? '-' }}</p>
                            <p class="mb-1">{{ $tanggapan->pemerintahProfile?->no_hp ?? '-' }}</p>
                            <p class="mb-1">Email: {{ $tanggapan->pemerintah?->email ?? '-' }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

</div>
@endsection
