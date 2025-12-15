@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width:500px;">
    <h2 class="mb-4 text-center display-6 fw-bold" style="color:#d32f2f;">
        Login RT/RW
    </h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login.rt_rw') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-danger fw-semibold">Login</button>
            <a href="{{ route('rt-rw.register.form') }}" class="btn btn-secondary fw-semibold">
                Daftar Sebagai RT/RW
            </a>
        </div>
    </form>

</div>
@endsection
