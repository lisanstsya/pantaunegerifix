@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Laporan</h2>

    <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('laporan._form')

        <button class="btn btn-success mt-3">Update Laporan</button>
    </form>
</div>
@endsection
