@extends('layouts.app') 

@section('content')
<div class="d-flex justify-content-center align-items-start py-5" style="min-height: 90vh; background-color: #fff;">
    <div class="card shadow-lg rounded p-4 mt-5" style="width: 100%; max-width: 900px; background-color: #fff;">
        <h2 class="mb-4 text-center fw-bold" style="color:#d32f2f; font-size:1.5rem;">
            Register RT/RW
        </h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('rt-rw.store-profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-semibold">Foto Profil</label>
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*" required>
                        @error('foto')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Nama</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama" required>
                        @error('nama')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Masukkan jabatan" required>
                        @error('jabatan')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="mb-3 col">
                            <label class="fw-semibold">RT</label>
                            <input type="number" name="rt" class="form-control @error('rt') is-invalid @enderror" placeholder="RT" required>
                            @error('rt')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col">
                            <label class="fw-semibold">RW</label>
                            <input type="number" name="rw" class="form-control @error('rw') is-invalid @enderror" placeholder="RW" required>
                            @error('rw')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" placeholder="Provinsi" required>
                        @error('provinsi')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-semibold">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten_kota" class="form-control @error('kabupaten_kota') is-invalid @enderror" placeholder="Kabupaten/Kota" required>
                        @error('kabupaten_kota')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" placeholder="Kecamatan" required>
                        @error('kecamatan')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Kelurahan</label>
                        <input type="text" name="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror" placeholder="Kelurahan" required>
                        @error('kelurahan')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">No HP</label>
                        <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="0812xxxxxxx" pattern="[0-9]+" title="Hanya angka" required>
                        @error('no_hp')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@domain.com" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Masukkan email valid">
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Password</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required oninput="validatePassword()">
                        <small id="passwordHelp" class="text-danger small"></small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-semibold mb-2">Daftar</button>
        </form>

        <div class="text-center mt-2">
            <p class="fw-semibold mb-0">
                Sudah punya akun? 
                <a href="{{ route('login.rt_rw.form') }}">Login</a>
            </p>
        </div>
    </div>
</div>

{{-- Script validasi password --}}
<script>
function validatePassword() {
    const pass = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    const helpText = document.getElementById('passwordHelp');

    if(confirm && pass !== confirm){
        helpText.textContent = "Password tidak cocok";
    } else {
        helpText.textContent = "";
    }
}
</script>
@endsection
