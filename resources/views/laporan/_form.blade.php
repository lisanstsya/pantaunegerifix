<div class="mb-3">
    <label class="form-label">Deskripsi Laporan</label>
    <textarea name="deskripsi" class="form-control" required>{{ old('deskripsi', $laporan->deskripsi ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Lokasi RT</label>
    <input type="text" name="lokasi_rt" class="form-control"
        value="{{ old('lokasi_rt', $laporan->lokasi_rt ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Lokasi RW</label>
    <input type="text" name="lokasi_rw" class="form-control"
        value="{{ old('lokasi_rw', $laporan->lokasi_rw ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Kelurahan</label>
    <input type="text" name="kelurahan" class="form-control"
        value="{{ old('kelurahan', $laporan->kelurahan ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Kecamatan</label>
    <input type="text" name="kecamatan" class="form-control"
        value="{{ old('kecamatan', $laporan->kecamatan ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Kota</label>
    <input type="text" name="kota" class="form-control"
        value="{{ old('kota', $laporan->kota ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Provinsi</label>
    <input type="text" name="provinsi" class="form-control"
        value="{{ old('provinsi', $laporan->provinsi ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Permintaan Solusi</label>
    <textarea name="permintaan_solusi" class="form-control" required>{{ old('permintaan_solusi', $laporan->permintaan_solusi ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Upload Bukti (Foto)</label>
    <input type="file" name="bukti" class="form-control">
    
    @if(!empty($laporan->bukti))
        <img src="{{ asset('storage/' . $laporan->bukti) }}" width="150" class="mt-2">
    @endif
</div>
