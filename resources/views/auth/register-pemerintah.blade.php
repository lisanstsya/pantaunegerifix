@extends('layouts.auth')

@section('content')
<div class="container mt-5" style="max-width: 500px;">
    <h3 class="mb-4 text-center display-6 fw-bold" style="color:#d32f2f;">
        Registrasi Pemerintah
    </h3>

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

        <div class="mb-3">
            <label class="fw-semibold">Foto Profil</label>
            <input type="file" name="profile_photo" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Nama</label>
            <input type="text" name="name" class="form-control" required autocomplete="name">
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Instansi</label>
            <input type="text" name="instansi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Kota</label>
            <input type="text" name="kota" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Provinsi</label>
            <input type="text" name="provinsi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">No HP</label>
            <input type="text" name="no_hp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" required autocomplete="email">
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" required autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-danger w-100 fw-semibold">Daftar</button>
    </form>

    <div class="text-center mt-3">
        <p class="fw-semibold mb-0">Sudah punya akun? 
            <a href="{{ route('login.pemerintah.form') }}">Login</a>
        </p>
    </div>
</div>
@endsection
