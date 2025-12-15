@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- Header --}}
    <div class="mb-4">
        <h4 class="fw-bold">Buat Tanggapan</h4>
        <p class="text-muted mb-0">
            Untuk laporan: <strong>{{ $laporan->judul }}</strong>
        </p>
    </div>

    <div class="row g-4">

        {{-- DETAIL LAPORAN --}}
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

                    <h6 class="fw-bold">{{ $laporan->judul }}</h6>

                    <small class="text-muted d-block mb-2">
                        📍 {{ $laporan->lokasi_detail }},
                        {{ $laporan->kabupaten }},
                        {{ $laporan->provinsi ?? '-' }}
                    </small>

                    <small class="text-muted d-block mb-3">
                        🗓 {{ \Carbon\Carbon::parse($laporan->waktu_laporan)->format('d M Y') }}
                    </small>

                    <p class="text-muted small">
                        {{ $laporan->isi }}
                    </p>

                    {{-- Foto pelapor --}}
                    <div class="d-flex align-items-center gap-2 mt-2">
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM TANGGAPAN --}}
        <div class="col-md-7">
            <div class="card shadow-sm rounded-4">
                <div class="card-body">

                    <form action="{{ route('tanggap.store', $laporan) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Isi Tanggapan --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Tanggapan</label>
                            <textarea name="isi" class="form-control"
                                      rows="4" required>{{ old('isi') }}</textarea>
                        </div>

                        {{-- Foto --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Dokumentasi</label>
                            <input type="file" name="foto"
                                   class="form-control" accept="image/*">
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai"
                                   class="form-control"
                                   value="{{ old('tanggal_selesai', now()->format('Y-m-d')) }}">
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Laporan</label>
                            <select name="status" class="form-select" required>
                                <option value="baru">Baru</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-danger">
                                Kirim Tanggapan
                            </button>

                            <a href="{{ route('laporan.show', $laporan) }}"
                               class="btn btn-secondary">
                                Kembali
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
