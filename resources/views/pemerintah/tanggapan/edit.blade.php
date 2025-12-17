@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="mb-4">
        <h4 class="fw-bold">Edit Tanggapan</h4>
        <p class="text-muted mb-0">
            Untuk laporan: <strong>{{ $tanggapan->laporan->judul }}</strong>
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-5">
            <div class="card shadow-sm rounded-4 overflow-hidden">

                @if($tanggapan->laporan->media)
                    <img src="{{ asset('storage/'.$tanggapan->laporan->media) }}"
                         style="height:200px; object-fit:cover"
                         class="w-100">
                @endif

                <div class="card-body">
                    <span class="badge 
                        {{ $tanggapan->laporan->status == 'baru' ? 'bg-warning text-dark' : 'bg-info' }}">
                        {{ ucfirst($tanggapan->laporan->status) }}
                    </span>

                    <h6 class="fw-bold mt-2">{{ $tanggapan->laporan->judul }}</h6>

                    <small class="text-muted d-block mb-2">
                        📍 {{ $tanggapan->laporan->lokasi_detail }},
                        {{ $tanggapan->laporan?->kelurahan ?? '-' }},
                        {{ $tanggapan->laporan?->kecamatan ?? '-' }},
                        {{ $tanggapan->laporan?->kabupaten_kota ?? '-' }}
                    </small>

                    <small class="text-muted d-block mb-3">
                        🗓 Tanggal Kejadian: {{ \Carbon\Carbon::parse($tanggapan->laporan->tanggal_kejadian)->format('d M Y') }}
                    </small>

                    <p class="text-muted small">{{ $tanggapan->laporan->isi }}</p>

                    @if(auth()->user()->role === 'pemerintah')
                        @php
                            $rtRw = $tanggapan->laporan->user?->rtRwProfile;
                            $fotoPelaporUrl = ($rtRw && $rtRw->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($rtRw->foto))
                                              ? asset('storage/'.$rtRw->foto)
                                              : asset('images/default-avatar.png');
                        @endphp
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" 
                                data-bs-toggle="modal" data-bs-target="#pelaporModal">
                            Lihat Detail Pelapor
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm rounded-4">
                <div class="card-body">
                    <form action="{{ route('tanggapan.update', $tanggapan->id) }}" 
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Tanggapan</label>
                            <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" 
                                      rows="4" required>{{ old('isi', $tanggapan->isi) }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Dokumentasi (opsional)</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($tanggapan->foto)
                                <p class="mt-2">Foto saat ini:</p>
                                <img src="{{ asset('storage/'.$tanggapan->foto) }}" class="img-fluid rounded" style="max-height:250px;">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" 
                                   class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                   value="{{ old('tanggal_selesai', $tanggapan->tanggal_selesai ? $tanggapan->tanggal_selesai->format('Y-m-d') : '') }}" 
                                   required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Laporan</label>
                            <input type="text" class="form-control" value="{{ ucfirst($tanggapan->laporan->status) }}" readonly>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">
                                Update Tanggapan
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@if(auth()->user()->role === 'pemerintah')
<div class="modal fade" id="pelaporModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pelapor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ $fotoPelaporUrl }}" class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
                <h6 class="fw-bold">{{ $tanggapan->laporan->user?->name ?? 'Anonim' }}</h6>
                <p class="mb-1">RT {{ $rtRw?->rt ?? '-' }}, RW {{ $rtRw?->rw ?? '-' }}</p>
                <p class="mb-1">{{ $rtRw?->kelurahan ?? '-' }}, {{ $rtRw?->kecamatan ?? '-' }}</p>
                <p class="mb-1">{{ $rtRw?->kabupaten_kota ?? '-' }}, {{ $rtRw?->provinsi ?? '-' }}</p>
                <p class="mb-1">No HP: {{ $tanggapan->laporan->user?->no_hp ?? '-' }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
