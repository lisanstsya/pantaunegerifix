@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width:500px;">
    <h2 class="mb-4 text-center">Login RT/RW</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login.rt-rw.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger w-100">Login</button>
    </form>

    <p class="mt-3 text-center">
        Belum punya akun? <a href="{{ route('rt-rw.register') }}">Daftar RT/RW</a>
    </p>
</div>
@endsection
