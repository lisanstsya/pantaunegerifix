@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center mt-5 mb-5">
    <div class="card shadow-lg p-4 rounded" style="width: 100%; max-width: 900px;">
        <h3 class="mb-4 text-center fw-bold" style="color:#d32f2f;">Buat Laporan Baru</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Laporan</label>
                        <input type="text" name="judul" id="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               placeholder="Masukkan judul laporan" 
                               value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Laporan</label>
                        <select name="kategori" id="kategori"
                                class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Infrastruktur" {{ old('kategori') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                            <option value="Kebersihan" {{ old('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="Keamanan" {{ old('kategori') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                            <option value="Pelayanan Publik" {{ old('kategori') == 'Pelayanan Publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                            <option value="Lingkungan" {{ old('kategori') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                            <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Laporan</label>
                        <textarea name="isi" id="isi" rows="5"
                                  class="form-control @error('isi') is-invalid @enderror"
                                  placeholder="Tuliskan isi laporan secara jelas" required>{{ old('isi') }}</textarea>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="media" class="form-label">Foto / Video</label>
                        <input type="file" name="media" id="media"
                               class="form-control @error('media') is-invalid @enderror"
                               accept="image/*,video/*"
                               required>
                        @error('media')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
                        <input type="date" name="tanggal_kejadian" id="tanggal_kejadian"
                               class="form-control @error('tanggal_kejadian') is-invalid @enderror"
                               value="{{ old('tanggal_kejadian') }}" required>
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
                               placeholder="Contoh: Jalan Sudirman No. 12" 
                               value="{{ old('lokasi_detail') }}" required>
                        @error('lokasi_detail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan"
                                   class="form-control @error('kecamatan') is-invalid @enderror"
                                   placeholder="Kecamatan" 
                                   value="{{ old('kecamatan') }}" required>
                            @error('kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <input type="text" name="kelurahan" id="kelurahan"
                                   class="form-control @error('kelurahan') is-invalid @enderror"
                                   placeholder="Kelurahan" 
                                   value="{{ old('kelurahan') }}" required>
                            @error('kelurahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                <div class="mb-3">
                    <label for="kabupaten_kota" class="form-label">Kabupaten / Kota</label>
                    <input type="text" name="kabupaten_kota" id="kabupaten_kota"
                        class="form-control @error('kabupaten_kota') is-invalid @enderror"
                        placeholder="Contoh: Kabupaten/Kota" 
                        value="{{ old('kabupaten_kota') }}" required>
                    @error('kabupaten_kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                    <div class="mb-3">
                        <label for="permintaan_solusi" class="form-label">Permintaan Solusi</label>
                        <textarea name="permintaan_solusi" id="permintaan_solusi" rows="3"
                                  class="form-control @error('permintaan_solusi') is-invalid @enderror"
                                  placeholder="Tuliskan solusi yang diharapkan" required>{{ old('permintaan_solusi') }}</textarea>
                        @error('permintaan_solusi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-danger w-50 fw-semibold">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>
@endsection
