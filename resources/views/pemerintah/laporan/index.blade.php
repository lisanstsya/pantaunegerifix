@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 fw-bold">Daftar Laporan</h2>

    <form action="{{ route('laporan') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" 
                   placeholder="Cari laporan..." 
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    @if($laporans->count() > 0)
        <div class="row g-3">
            @foreach($laporans as $laporan)
                <div class="col-md-6">
                    <div class="card shadow-sm h-100" style="border-radius:12px; overflow:hidden;">

                        {{-- Foto Laporan --}}
                        @if($laporan->media)
                            <img src="{{ asset('storage/' . $laporan->media) }}" 
                                 class="img-fluid"
                                 style="width:100%; max-height:250px; object-fit:cover;">
                        @endif

                        <div class="card-body d-flex">
                            
                            {{-- Foto Pelapor --}}
                            @php
                                $fotoPelapor = $laporan->user?->rtRwProfile?->foto;
                            @endphp

                            @if($fotoPelapor && \Illuminate\Support\Facades\Storage::disk('public')->exists('foto_rt_rw/'.$fotoPelapor))
                                <img src="{{ asset('storage/foto_rt_rw/' . $fotoPelapor) }}" 
                                     alt="Foto Pelapor" 
                                     class="me-3"
                                     style="width:60px; height:60px; border-radius:50%; object-fit:cover;">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" 
                                     alt="Foto Pelapor" 
                                     class="me-3"
                                     style="width:60px; height:60px; border-radius:50%; object-fit:cover;">
                            @endif

                            {{-- Info Laporan --}}
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1">{{ $laporan->judul }}</h5>
                                <p class="mb-1"><strong>Pelapor:</strong> {{ $laporan->user?->name ?? 'Anonim' }}</p>

                                @php $rtRw = $laporan->user?->rtRwProfile; @endphp
                                <p class="mb-1" style="font-size:0.9rem;">
                                    <strong>Lokasi:</strong> 
                                    RT {{ $rtRw?->rt ?? '-' }}, 
                                    RW {{ $rtRw?->rw ?? '-' }}, 
                                    {{ $rtRw?->kelurahan ?? '-' }},
                                    {{ $rtRw?->kecamatan ?? '-' }},
                                    {{ $rtRw?->kabupaten_kota ?? '-' }},
                                    {{ $rtRw?->provinsi ?? '-' }}
                                </p>

                                <p class="mb-1">
                                    <strong>Status:</strong> 
                                    <span class="badge bg-warning text-dark">{{ $laporan->status ?? '-' }}</span>
                                </p>

                                <p class="mb-2" style="font-size:0.9rem;">
                                    {{ \Illuminate\Support\Str::limit($laporan->isi, 120) }}
                                </p>

                                <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $laporans->withQueryString()->links() }}
        </div>
        
    @else
        <div class="text-center mt-5">
            <p class="fs-5 text-muted">Belum ada laporan ditemukan.</p>
        </div>
    @endif

</div>
@endsection
