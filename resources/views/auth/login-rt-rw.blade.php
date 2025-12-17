@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4 rounded" style="width: 100%; max-width: 400px;">
        <h2 class="mb-4 text-center fw-bold" style="color:#d32f2f; font-size:1.5rem;">
            Login RT/RW
        </h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.rt_rw') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <div class="mb-4">
                <label class="fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-semibold mb-2">Login</button>
            <a href="{{ route('rt-rw.register.form') }}" class="btn btn-outline-secondary w-100 fw-semibold">
                Daftar Sebagai RT/RW
            </a>
        </form>
    </div>
</div>
@endsection
