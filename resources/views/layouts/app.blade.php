<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        /* Variabel Warna Kustom untuk konsistensi */
        :root {
            --primary: #0d6efd; /* Biru Bootstrap */
            --primary-light: #e6f0ff;
            --background: #f4f6f9; /* Latar Belakang lebih bersih */
            --card-bg: #ffffff;
            --text-color: #1f2937; /* Teks utama lebih gelap */
        }

        body {
            background: var(--background);
            color: var(--text-color);
            /* Menggunakan font default sistem yang modern */
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        /* --- Navbar (Peningkatan Desain) --- */
        .simple-navbar {
            background: var(--card-bg);
            border-bottom: none; /* Hilangkan border lama */
            /* Tambahkan Shadow halus untuk efek mengambang (premium feel) */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }

        .simple-navbar .navbar-brand {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 700 !important;
            letter-spacing: -0.5px;
        }

        .simple-navbar .nav-link {
            padding: 12px 18px; /* Padding lebih luas */
            font-weight: 500;
            color: var(--text-color);
            position: relative;
            transition: all 0.2s ease-in-out;
            display: flex; /* Untuk meratakan ikon */
            align-items: center;
        }

        .simple-navbar .nav-link:hover {
            color: var(--primary);
        }

        .simple-navbar .nav-link i {
            margin-right: 8px; /* Jarak antara ikon dan teks */
        }
        
        /* Underline ketika aktif - lebih tebal dan berwarna */
        .simple-navbar .nav-link.active {
            color: var(--primary); /* Teks aktif juga berwarna biru */
        }

        .simple-navbar .nav-link.active::after {
            content: "";
            position: absolute;
            bottom: 0; /* Posisikan tepat di bagian bawah navbar */
            left: 50%;
            transform: translateX(-50%); /* Rata tengah */
            width: 80%;
            height: 3px; /* Lebih tebal */
            background: var(--primary);
            border-radius: 3px 3px 0 0;
        }

        .profile-img {
            width: 36px; /* Sedikit lebih besar */
            height: 36px;
            object-fit: cover;
            border: 2px solid var(--primary-light); /* Garis luar tipis */
        }

        /* Gaya Dropdown yang lebih modern */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
        }

        .dropdown-item.text-danger:hover {
            background-color: #fcebeb; 
        }

        /* Container utama untuk konten */
        .main-content-container {
            padding-top: 30px !important;
            padding-bottom: 30px !important;
        }

        /* Responsif untuk mobile */
        @media (max-width: 991.98px) {
            .simple-navbar .nav-link.active::after {
                width: 50px; 
                left: 1rem;
                transform: translateX(0);
                bottom: -5px;
            }
            .simple-navbar .nav-link {
                justify-content: start; 
            }
        }
    </style>
</head>

<body>

@if(Auth::check())
<nav class="navbar navbar-expand-lg simple-navbar sticky-top">
    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            FinTrack
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" 
                       href="{{ route('home') }}">
                       <i class="bi bi-house-door-fill"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::is('transactions.*') ? 'active' : '' }}"
                       href="{{ route('transactions.index') }}">
                       <i class="bi bi-arrow-left-right"></i> Transaksi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}"
                       href="{{ route('categories.index') }}">
                       <i class="bi bi-tags-fill"></i> Kategori
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" 
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->profile_picture_url ?? 'https://via.placeholder.com/150' }}"
                             class="rounded-circle profile-img me-2" alt="Profil Pengguna">
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="bi bi-person-circle me-2"></i> Profile Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
@endif

<div class="container main-content-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('failed'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@vite(['resources/js/app.js'])

</body>
</html>