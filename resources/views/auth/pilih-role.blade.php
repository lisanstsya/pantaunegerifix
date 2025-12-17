@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4 rounded" style="max-width: 400px; width: 100%;">
        <h3 class="fw-bold text-center mb-4" style="color:#d32f2f;">Pilih Role Anda</h3>

        <form method="GET" action="{{ route('auth.pilih-role.process') }}">
            <select name="role" class="form-select mb-3" required>
                <option value="">Masuk sebagai</option>
                <option value="masyarakat">Masyarakat</option>
                <option value="rt_rw">RT / RW</option>
                <option value="pemerintah">Pemerintah</option>
            </select>

            <button class="btn btn-danger w-100">Lanjut</button>
        </form>
    </div>
</div>
@endsection
