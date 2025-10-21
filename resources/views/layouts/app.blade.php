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
        }

        .navbar-nav .nav-link {
            border-radius: .5rem;
            padding: .6rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
            color: #fff;
        }

        .navbar-nav .dropdown-toggle {
            margin-left: 10px;
        }

        /* ==== Sidebar Styling ==== */
        .sidebar {
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
            min-height: calc(100vh - 76px);
            padding: 0;
        }

        .sidebar .nav-link {
            color: #495057;
            padding: 12px 20px;
            border-radius: 0;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: #0d6efd;
            border-left-color: #0d6efd;
        }

        .sidebar .nav-link.active {
            background-color: #e7f1ff;
            color: #0d6efd;
            border-left-color: #0d6efd;
            font-weight: 600;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .main-content {
            min-height: calc(100vh - 120px);
        }

        .footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">

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
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                                        <i class="fas fa-user-cog me-2"></i>Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
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

    <!-- Main Content dengan Sidebar -->
    <div class="main-content flex-grow-1">
        @if(Auth::check() && Route::is('profile.*'))
            <!-- Layout dengan Sidebar untuk Profile -->
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-3 col-lg-2 sidebar">
                        <nav class="nav flex-column py-3">
                            <a class="nav-link {{ Route::is('profile.index') ? 'active' : '' }}" 
                               href="{{ route('profile.index') }}">
                                <i class="fas fa-user-edit"></i>Edit Profile
                            </a>
                            <a class="nav-link {{ Route::is('profile.password') ? 'active' : '' }}" 
                               href="{{ route('profile.password') }}">
                                <i class="fas fa-key"></i>Ganti Password
                            </a>
                            <hr>
                            <form method="POST" action="{{ route('logout') }}" class="nav-link">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none">
                                    <i class="fas fa-sign-out-alt"></i>Logout
                                </button>
                            </form>
                        </nav>
                    </div>

                    <!-- Content Area -->
                    <div class="col-md-9 col-lg-10 py-4">
                        @yield('content')
                    </div>
                </div>
            </div>
        @else
            <!-- Layout normal untuk halaman lainnya -->
            @if(Auth::check())
                <div class="container py-4">
                    @yield('content')
                </div>
            @else
                <div class="container-fluid">
                    <div class="row justify-content-center align-items-center min-vh-100 py-4">
                        <div class="col-md-5 col-lg-4">
                            @yield('content')
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>

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

    <!-- Footer -->
    <footer class="footer bg-light border-top mt-auto py-3">
        <div class="container text-center">
            <h6 class="fw-semibold mb-0 text-muted">© 2025 - Muhamad Fathir Rahman</h6>
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