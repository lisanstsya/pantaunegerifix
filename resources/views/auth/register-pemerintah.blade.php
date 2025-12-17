@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-start py-5" style="min-height: 90vh; background-color: #fff;">
    <div class="card shadow-lg rounded p-4 mt-5" style="width: 100%; max-width: 900px;">
        <h2 class="mb-4 text-center fw-bold" style="color:#d32f2f; font-size:1.5rem;">
            Registrasi Pemerintah
        </h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pemerintah.register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-semibold">Foto Profil</label>
                        <input type="file" name="profile_photo" class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*" required>
                        @error('profile_photo')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap" required autocomplete="name">
                        @error('name')
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

                    <div class="mb-3">
                        <label class="fw-semibold">Instansi</label>
                        <input type="text" name="instansi" class="form-control @error('instansi') is-invalid @enderror" placeholder="Masukkan instansi" required>
                        @error('instansi')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Kota</label>
                        <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror" placeholder="Masukkan kota" required>
                        @error('kota')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-semibold">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" placeholder="Masukkan provinsi" required>
                        @error('provinsi')
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
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi password" required oninput="validatePassword()">
                        <small id="passwordHelp" class="text-danger small"></small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-semibold mb-2">Daftar</button>
        </form>

        <div class="text-center mt-3">
            <p class="fw-semibold mb-0">
                Sudah punya akun? 
                <a href="{{ route('login.pemerintah.form') }}">Login</a>
            </p>
        </div>
    </div>
</div>

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
