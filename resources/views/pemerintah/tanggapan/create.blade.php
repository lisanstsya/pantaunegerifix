@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="mb-4">
        <h4 class="fw-bold">Buat Tanggapan</h4>
        <p class="text-muted mb-0">
            Untuk laporan: <strong>{{ $laporan->judul }}</strong>
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-5">
            <div class="card shadow-sm rounded-4 overflow-hidden">

                @if($laporan->media)
                    <img src="{{ asset('storage/'.$laporan->media) }}"
                         style="height:200px; object-fit:cover"
                         class="w-100">
                @endif

                <div class="card-body">
                    <span class="badge 
                        {{ $laporan->status == 'baru' ? 'bg-warning text-dark' : 'bg-info' }}">
                        {{ ucfirst($laporan->status) }}
                    </span>

                    <h6 class="fw-bold mt-2">{{ $laporan->judul }}</h6>

                    <small class="text-muted d-block mb-2">
                        📍 {{ $laporan->lokasi_detail }},
                        {{ $laporan?->kelurahan ?? '-' }}, 
                        {{ $laporan?->kecamatan ?? '-' }},
                        {{ $laporan?->kabupaten_kota ?? '-' }}
                    </small>

                    <small class="text-muted d-block mb-3">
                        🗓 Tanggal Kejadian: {{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->format('d M Y') }}
                    </small>

                    <p class="text-muted small">{{ $laporan->isi }}</p>

                    @php
                        $rtRw = $laporan->user?->rtRwProfile;
                        $fotoPelaporUrl = ($rtRw && $rtRw->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($rtRw->foto))
                                          ? asset('storage/'.$rtRw->foto)
                                          : asset('images/default-avatar.png');
                    @endphp
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" data-bs-toggle="modal" data-bs-target="#pelaporModal">
                        Lihat Detail Pelapor
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm rounded-4">
                <div class="card-body">

                    <form action="{{ route('tanggap.store', $laporan) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Tanggapan</label>
                            <textarea name="isi" class="form-control"
                                      rows="4" required>{{ old('isi') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Dokumentasi</label>
                            <input type="file" name="foto"
                                   class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai"
                                   class="form-control"
                                   value="{{ old('tanggal_selesai', now()->format('Y-m-d')) }}"
                                   max="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Laporan</label>
                            <select name="status" class="form-select" required>
                                <option value="selesai" selected>Selesai</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-danger">Kirim Tanggapan</button>
                            <a href="{{ route('laporan.show', $laporan) }}" class="btn btn-secondary">Kembali</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="pelaporModal" tabindex="-1" aria-labelledby="pelaporModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="pelaporModalLabel">Detail Pelapor</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ $fotoPelaporUrl }}" class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
        <h5 class="fw-bold">{{ $laporan->user?->name ?? 'Anonim' }}</h5>
        <p class="mb-1">RT {{ $rtRw?->rt ?? '-' }}, RW {{ $rtRw?->rw ?? '-' }}</p>
        <p class="mb-1">{{ $rtRw?->kelurahan ?? '-' }}, {{ $rtRw?->kecamatan ?? '-' }}</p>
        <p class="mb-1">{{ $rtRw?->kabupaten_kota ?? '-' }}, {{ $rtRw?->provinsi ?? '-' }}</p>
        <p class="mb-1">No HP: {{ $laporan->user?->no_hp ?? '-' }}</p>
        <p class="mb-1">Email: {{ $laporan->user?->email ?? '-' }}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection
