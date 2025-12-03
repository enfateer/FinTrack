<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login To FinTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Gaya Konsisten dengan Fade In Up */
        .fade-in-up {
            animation: fadeInUp 0.7s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Mengatur background dan centering body */
        body {
            background-color: #f8f9fa; /* bg-gray-50 setara dengan Bootstrap bg-light */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* Gaya Card modern */
        .card-login {
            max-width: 420px;
            width: 100%;
            border: none;
            border-radius: 1rem; /* rounded-xl */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* shadow-xl */
        }

        /* Gaya Input Focus yang lebih modern */
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); /* Ring fokus */
        }
    </style>
</head>
<body>
    
    <div class="card card-login p-4 fade-in-up">
        <div class="card-body">

            <div class="text-center mb-5">
                <i class="bi bi-wallet-fill fs-1 text-primary mb-3"></i> <h2 class="h3 fw-bold text-dark mb-1">Masuk ke FinTrack</h2>
                <p class="text-muted">Kelola keuangan Anda dengan mudah</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3 shadow-sm py-3 mb-4">
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                        class="form-control" required autofocus autocomplete="email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" id="password" name="password" 
                        class="form-control" required autocomplete="current-password">
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label text-muted" for="remember_me">Ingat saya</label>
                </div>

                <button type="submit" 
                    class="btn btn-primary w-100 fw-bold py-2 shadow-sm transition">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>

                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>