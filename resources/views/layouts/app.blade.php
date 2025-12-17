<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pantau Negeri</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
        }

        .full-width-img {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Pantau Negeri</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('laporan') }}">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tanggapan.index') }}">Tanggapan</a></li>

@php $role = session('role', 'guest'); @endphp

@if($role == 'guest')
    <li class="nav-item"><a class="nav-link" href="{{ route('auth.pilih-role') }}">Masuk</a></li>
@elseif($role == 'masyarakat')
    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Keluar</a></li>
@elseif($role == 'rt_rw')
    <li class="nav-item"><a class="nav-link" href="{{ route('lapor') }}">Lapor</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Keluar</a></li>
@elseif($role == 'pemerintah')
    <li class="nav-item"><a class="nav-link" href="{{ route('tanggapan.pemerintah') }}">Tanggap</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Keluar</a></li>
@endif

                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper container-fluid mt-4 px-4">
        @yield('content')
    </div>

    <footer class="bg-danger text-white py-5 mt-5">
        <div class="container-fluid text-center">
            <h4 class="fw-bold">Pantau Negeri</h4>
            <p>Laporan masyarakat untuk Indonesia Adil dan Transparan.</p>

            <div class="mt-3">
                <a href="https://instagram.com/pantau_negeri" target="_blank" class="text-white me-3">
                    <i class="bi bi-instagram"></i> Instagram
                </a>
                <a href="mailto:info@pantau.negeri.id" class="text-white me-3">
                    <i class="bi bi-envelope"></i> Email
                </a>
                <a href="tel:+628123456789" class="text-white">
                    <i class="bi bi-telephone"></i> +62 888-8888-888
                </a>
            </div>
        </div>
    </footer>

    <footer class="bg-dark text-light py-3">
        <div class="container-fluid text-center">
            <p class="mb-0">© {{ date('Y') }} Pantau Negeri - All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
