@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-start py-5" style="min-height: 80vh; background-color: #fff;">
    <div class="card shadow-lg rounded p-4 mt-5" style="width: 100%; max-width: 400px;">
        <h2 class="mb-4 text-center fw-bold" style="color:#d32f2f; font-size:1.5rem;">
            Login Pemerintah
        </h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.pemerintah') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="fw-semibold">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="Masukkan email pemerintah"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="fw-semibold">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-semibold mb-2">Login</button>
            <a href="{{ route('pemerintah.register.form') }}" class="btn btn-outline-secondary w-100 fw-semibold">
                Daftar Sebagai Pemerintah
            </a>
        </form>
    </div>
</div>
@endsection
