<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register FinTrack</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN untuk konsistensi ikon -->
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
        .card-register {
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
    
    <!-- Register Card (dengan animasi) -->
    <div class="card card-register p-4 fade-in-up">
        <div class="card-body">

            <div class="text-center mb-5">
                <i class="bi bi-person-fill-add fs-1 text-primary mb-3"></i> <!-- Ikon BS: User Add -->
                <h2 class="h3 fw-bold text-dark mb-1">Daftar Akun Baru</h2>
                <p class="text-muted">Buat akun untuk mulai mengelola keuangan Anda</p>
            </div>

            <!-- Display Validation Errors -->
            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3 shadow-sm py-3 mb-4">
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Nama Lengkap Input -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                        class="form-control" required autofocus autocomplete="name">
                </div>

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                        class="form-control" required autocomplete="email">
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" id="password" name="password" 
                        class="form-control" required autocomplete="new-password">
                </div>

                <!-- Konfirmasi Password Input -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                        class="form-control" required autocomplete="new-password">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="btn btn-primary w-100 fw-bold py-2 shadow-sm transition">
                    <i class="bi bi-person-check-fill me-2"></i>Daftar
                </button>

                <!-- Login Link -->
                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">
                            Login di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>