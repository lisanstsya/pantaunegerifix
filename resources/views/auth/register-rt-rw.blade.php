@extends('layouts.auth')

@section('content')
<div class="container mt-5" style="max-width:600px;">
    <h2 class="mb-4 text-center display-6 fw-bold" style="color:#d32f2f;">
        Register RT/RW
    </h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('rt-rw.store-profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Form inputs sama seperti sebelumnya -->
        <div class="mb-3">
            <label class="fw-semibold">Foto Profil</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label class="fw-semibold">RT</label>
                <input type="number" name="rt" class="form-control" required>
            </div>
            <div class="mb-3 col">
                <label class="fw-semibold">RW</label>
                <input type="number" name="rw" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Provinsi</label>
            <input type="text" name="provinsi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Kabupaten/Kota</label>
            <input type="text" name="kabupaten_kota" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Kecamatan</label>
            <input type="text" name="kecamatan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Kelurahan</label>
            <input type="text" name="kelurahan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">No HP</label>
            <input type="text" name="no_hp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger w-100 fw-semibold">Daftar</button>
    </form>

    <div class="text-center mt-3">
        <p class="fw-semibold mb-0">Sudah punya akun? 
            <a href="{{ route('login.rt_rw.form') }}">Login</a>
        </p>
    </div>
</div>
@endsection
