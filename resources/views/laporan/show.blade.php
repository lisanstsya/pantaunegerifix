@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 fw-bold">Detail Laporan</h2>

    {{-- Laporan --}}
    <div class="card shadow-sm mb-4">
        @if($laporan->media)
            <a href="{{ asset('storage/'.$laporan->media) }}" target="_blank">
                <img src="{{ asset('storage/'.$laporan->media) }}" 
                     class="img-fluid" style="width:100%; max-height:450px; object-fit:cover;">
            </a>
        @endif

        <div class="card-body">
            <h3 class="fw-bold">{{ $laporan->judul }}</h3>

            {{-- Info Pelapor --}}
            @php
                $rtRw = $laporan->user?->rtRwProfile;
                $fotoPelapor = $rtRw?->foto;

                // Sesuaikan path double 'public'
                if($fotoPelapor) {
                    $fotoPelaporUrl = asset('storage/public/'.$fotoPelapor);
                } else {
                    $fotoPelaporUrl = asset('images/default-avatar.png');
                }
            @endphp
            <div class="d-flex align-items-center mt-3">
                <img src="{{ $fotoPelaporUrl }}"
                     class="rounded-circle border me-2" 
                     style="width:40px; height:40px; object-fit:cover;">
                <div style="font-size:0.82rem;">
                    <div class="fw-bold">{{ $laporan->user?->name ?? 'Anonim' }}</div>
                    <div>
                        RT {{ $rtRw?->rt ?? '-' }}, RW {{ $rtRw?->rw ?? '-' }},
                        {{ $rtRw?->kelurahan ?? '-' }}, {{ $rtRw?->kecamatan ?? '-' }},
                        {{ $rtRw?->kabupaten_kota ?? '-' }}, {{ $rtRw?->provinsi ?? '-' }}
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <strong>Waktu laporan:</strong>
                <p>{{ $laporan->waktu_laporan }}</p>
            </div>

            {{-- Deskripsi --}}
            <div class="mt-3">
                <strong>Deskripsi Laporan:</strong>
                <p>{{ $laporan->isi }}</p>
            </div>

            @if($laporan->permintaan_solusi)
                <div class="mt-2">
                    <strong>Permintaan Solusi:</strong>
                    <p>{{ $laporan->permintaan_solusi }}</p>
                </div>
            @endif
        </div>
    </div>
    <br />
    {{-- Tanggapan --}}
    <h4 class="mb-3">Tanggapan</h4>
    @if($laporan->tanggapans->count() > 0)
        @foreach($laporan->tanggapans as $tanggapan)
            @php
                $pejabat = $tanggapan->pemerintahProfile;
                $fotoPejabat = $pejabat?->foto;

                // Sesuaikan path double 'public'
                if($fotoPejabat) {
                    $fotoPejabatUrl = asset('storage/public/'.$fotoPejabat);
                } else {
                    $fotoPejabatUrl = asset('images/default-avatar.png');
                }
            @endphp

           <div class="card mb-3 shadow-sm" style="background-color: #d4edda;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        {{-- Foto pejabat --}}
                        @php
                            $pejabat = $tanggapan->pemerintahProfile;
                            $fotoPejabat = $pejabat?->foto;

                            if($fotoPejabat && \Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPejabat)) {
                                $fotoPejabatUrl = asset('storage/'.$fotoPejabat);
                            } else {
                                $fotoPejabatUrl = asset('images/default-avatar.png');
                            }
                        @endphp

                        <img src="{{ $fotoPejabatUrl }}" 
                            class="me-3 rounded-circle" style="width:60px; height:60px; object-fit:cover;">


                        <div>
                            <p class="mb-0 fw-bold">{{ $tanggapan->pemerintah?->name ?? $tanggapan->petugas }}</p>
                            <p class="mb-0 text-muted" style="font-size:0.85rem;">
                                Jabatan: {{ $tanggapan->jabatan ?? '-' }} | 
                                Tanggal: {{ $tanggapan->tanggal_selesai ?? $tanggapan->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-2">
                         <p class="text-secondary fst-italic" style="font-size:1rem;">
                            "{{ $tanggapan->isi }}"
                        </p>
                        <strong>Dokumentasi Perbaikan : </strong>
                        @if($tanggapan->foto)
                            <a href="{{ asset('storage/'.$tanggapan->foto) }}" target="_blank">
                                <img src="{{ asset('storage/'.$tanggapan->foto) }}" 
                                    class="img-fluid rounded w-100" style="max-height:400px; object-fit:cover;">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>Belum ada tanggapan untuk laporan ini.</p>
    @endif

</div>
@endsection
