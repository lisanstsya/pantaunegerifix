@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-center text-danger">Edit Laporan</h2>

    <div class="d-flex justify-content-center">
        <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data" class="w-100" style="max-width:900px;">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Laporan</label>
                        <input type="text" name="judul" id="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $laporan->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" name="kategori" id="kategori"
                               class="form-control @error('kategori') is-invalid @enderror"
                               value="{{ old('kategori', $laporan->kategori) }}" required>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi" class="form-label">Deskripsi</label>
                        <textarea name="isi" id="isi" rows="5"
                                  class="form-control @error('isi') is-invalid @enderror" required>{{ old('isi', $laporan->isi) }}</textarea>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
<input type="date" name="tanggal_kejadian" id="tanggal_kejadian"
       class="form-control @error('tanggal_kejadian') is-invalid @enderror"
       value="{{ old('tanggal_kejadian', \Carbon\Carbon::parse($laporan->tanggal_kejadian)->format('Y-m-d')) }}" required>

                        @error('tanggal_kejadian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="lokasi_detail" class="form-label">Lokasi Detail</label>
                        <input type="text" name="lokasi_detail" id="lokasi_detail"
                               class="form-control @error('lokasi_detail') is-invalid @enderror"
                               value="{{ old('lokasi_detail', $laporan->lokasi_detail) }}" required>
                        @error('lokasi_detail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan"
                                   class="form-control @error('kecamatan') is-invalid @enderror"
                                   value="{{ old('kecamatan', $laporan->kecamatan) }}" required>
                            @error('kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <input type="text" name="kelurahan" id="kelurahan"
                                   class="form-control @error('kelurahan') is-invalid @enderror"
                                   value="{{ old('kelurahan', $laporan->kelurahan) }}" required>
                            @error('kelurahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="kabupaten_kota" class="form-label">Kabupaten / Kota</label>
                        <input type="text" name="kabupaten_kota" id="kabupaten_kota"
                               class="form-control @error('kabupaten_kota') is-invalid @enderror"
                               value="{{ old('kabupaten_kota', $laporan->kabupaten_kota) }}" required>
                        @error('kabupaten_kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="permintaan_solusi" class="form-label">Permintaan Solusi</label>
                        <textarea name="permintaan_solusi" id="permintaan_solusi" rows="3"
                                  class="form-control @error('permintaan_solusi') is-invalid @enderror">{{ old('permintaan_solusi', $laporan->permintaan_solusi) }}</textarea>
                        @error('permintaan_solusi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="media" class="form-label">Media (opsional)</label>
                        <input type="file" name="media" id="media"
                               class="form-control @error('media') is-invalid @enderror">
                        @error('media')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($laporan->media)
                            <p class="mt-2">Media saat ini:</p>
                            <img src="{{ asset('storage/'.$laporan->media) }}"
                                 class="img-fluid rounded" style="max-height:250px;">
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-danger px-5">Update Laporan</button>
                <a href="{{ route('laporan.show', $laporan) }}" class="btn btn-secondary px-4">Batal</a>
            </div>

        </form>
    </div>
</div>
@endsection
