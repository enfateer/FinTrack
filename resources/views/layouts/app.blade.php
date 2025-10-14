<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* ==== Styling Navbar ==== */
        .navbar-nav .nav-item {
            margin-right: 15px;
            /* 🔹 Jarak antar menu */
        }

        .navbar-nav .nav-link {
            border-radius: .5rem;
            padding: .6rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* 🔹 Hover lebih solid */
        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        /* 🔹 Active state lebih jelas */
        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
            color: #fff;
        }

        /* 🔹 Dropdown toggle spacing & color */
        .navbar-nav .dropdown-toggle {
            margin-left: 10px;
        }

        /* 🔹 Tambahkan jarak antara navbar dan konten */
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Navigation - hanya tampil jika user sudah login -->
    @if(Auth::check())
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <i class="fas fa-wallet me-2 fs-4"></i>
                    <span class="fw-bold">FinTrack App</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">

                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
                                <i class="fas fa-home me-2"></i>Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('transactions.index') }}"
                                class="nav-link {{ Route::is('transactions.*') ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt me-2"></i>Transaksi
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}"
                                class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}">
                                <i class="fas fa-tags me-2"></i>Kategori
                            </a>
                        </li>

                        <!-- Dropdown User -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
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

    <!-- Main Content -->
    <main
        class="@if(Auth::check()) container py-4 @else min-vh-100 d-flex align-items-center justify-content-center @endif">
        @yield('content')
    </main>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
            <div class="toast align-items-center text-white bg-success border-0 show" id="successToast" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
            <div class="toast align-items-center text-white bg-danger border-0 show" id="errorToast" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <footer class="text-center mt-3 mb-2 text-black shadow-sm py-2">
        <div class="container">
            <h6 class="fw-semibold">© 2025 - Muhamad Fathir Rahman</h6>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto hide toast setelah 5 detik
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                const toastElList = document.querySelectorAll('.toast');
                toastElList.forEach(toast => {
                    const bsToast = bootstrap.Toast.getOrCreateInstance(toast);
                    bsToast.hide();
                });
            }, 5000);
        });
    </script>

</body>

</html>