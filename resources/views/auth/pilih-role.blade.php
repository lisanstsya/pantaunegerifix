@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Pilih Role Anda</h2>

    {{-- pilih role lalu redirect ke halaman login sesuai role --}}
    <form method="GET" action="{{ route('auth.pilih-role.process') }}">
        <select name="role" class="form-select mb-3" required>
            <option value="">-- Pilih Peran --</option>
            <option value="masyarakat">Masyarakat</option>
            <option value="rt_rw">RT / RW</option>
            <option value="pemerintah">Pemerintah</option>
        </select>

        <button class="btn btn-primary w-100">Lanjut</button>
    </form>
</div>
@endsection
