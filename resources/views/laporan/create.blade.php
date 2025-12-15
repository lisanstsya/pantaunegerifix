@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 700px;">
    {{-- Judul Halaman --}}
    <h3 class="mb-4 text-center fw-bold" style="color:#d32f2f;">Buat Laporan Baru</h3>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- Judul --}}
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Laporan</label>
            <input type="text" name="judul" id="judul" 
                   class="form-control @error('judul') is-invalid @enderror" 
                   value="{{ old('judul') }}" required>
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Isi laporan --}}
        <div class="mb-3">
            <label for="isi" class="form-label">Isi Laporan</label>
            <textarea name="isi" id="isi" rows="5" 
                      class="form-control @error('isi') is-invalid @enderror" 
                      required>{{ old('isi') }}</textarea>
            @error('isi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Media --}}
        <div class="mb-3">
            <label for="media" class="form-label">Foto / Video (opsional)</label>
            <input type="file" name="media" id="media" 
                   class="form-control @error('media') is-invalid @enderror"
                   accept="image/*,video/*">
            @error('media')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Waktu laporan --}}
        <div class="mb-3">
            <label for="waktu_laporan" class="form-label">Waktu Laporan</label>
            <input type="datetime-local" name="waktu_laporan" id="waktu_laporan" 
                   class="form-control @error('waktu_laporan') is-invalid @enderror" 
                   value="{{ old('waktu_laporan') }}" required>
            @error('waktu_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Lokasi --}}
        <div class="mb-3">
            <label for="lokasi_detail" class="form-label">Lokasi Detail</label>
            <input type="text" name="lokasi_detail" id="lokasi_detail" 
                   class="form-control @error('lokasi_detail') is-invalid @enderror" 
                   value="{{ old('lokasi_detail') }}" required>
            @error('lokasi_detail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row g-3">
            {{-- Kecamatan --}}
            <div class="col-md-6">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" 
                       class="form-control @error('kecamatan') is-invalid @enderror" 
                       value="{{ old('kecamatan') }}" required>
                @error('kecamatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kelurahan --}}
            <div class="col-md-6">
                <label for="kelurahan" class="form-label">Kelurahan</label>
                <input type="text" name="kelurahan" id="kelurahan" 
                       class="form-control @error('kelurahan') is-invalid @enderror" 
                       value="{{ old('kelurahan') }}" required>
                @error('kelurahan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3 mt-1">
            {{-- Kabupaten --}}
            <div class="col-md-6">
                <label for="kabupaten" class="form-label">Kabupaten</label>
                <input type="text" name="kabupaten" id="kabupaten" 
                       class="form-control @error('kabupaten') is-invalid @enderror" 
                       value="{{ old('kabupaten') }}" required>
                @error('kabupaten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kota --}}
            <div class="col-md-6">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" name="kota" id="kota" 
                       class="form-control @error('kota') is-invalid @enderror" 
                       value="{{ old('kota') }}" required>
                @error('kota')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Permintaan Solusi --}}
        <div class="mb-3 mt-3">
            <label for="permintaan_solusi" class="form-label">Permintaan Solusi</label>
            <textarea name="permintaan_solusi" id="permintaan_solusi" rows="3" 
                      class="form-control @error('permintaan_solusi') is-invalid @enderror" 
                      required>{{ old('permintaan_solusi') }}</textarea>
            @error('permintaan_solusi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-danger w-50">Kirim Laporan</button>
        </div>
    </form>
</div>
@endsection
