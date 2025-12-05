@extends('layouts.app')

@section('content')
    <style>
        /* Gaya Konsistensi dari halaman lain */
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
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

        .card.shadow-sm {
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        }

        .password-strength {
            height: 8px;
            border-radius: 4px;
            transition: all 0.3s ease;
            margin-top: 5px;
        }

        .password-strength.weak {
            background-color: #dc3545;
            width: 33%;
        }

        .password-strength.medium {
            background-color: #ffc107;
            width: 66%;
        }

        .password-strength.strong {
            background-color: #28a745;
            width: 100%;
        }
    </style>

    <div class="container py-4 fade-in-up">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h1 class="h4 fw-bold text-dark mb-4 border-bottom pb-3">
                            <i class="bi bi-key-fill me-2 text-warning"></i> Ganti Password
                        </h1>

                        @if(session('success'))
                            <div class="alert alert-success border-0 rounded-3 mb-4">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger border-0 rounded-3 mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill me-2 text-secondary"></i>Password Saat Ini
                                </label>
                                <input type="password" name="current_password" id="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       required autocomplete="current-password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label fw-semibold">
                                    <i class="bi bi-shield-lock-fill me-2 text-primary"></i>Password Baru
                                </label>
                                <input type="password" name="new_password" id="new_password"
                                       class="form-control @error('new_password') is-invalid @enderror"
                                       required autocomplete="new-password">
                                <div class="password-strength" id="password-strength"></div>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Minimal 8 karakter dengan kombinasi huruf dan angka
                                </small>
                            </div>

                            <div class="mb-4">
                                <label for="new_password_confirmation" class="form-label fw-semibold">
                                    <i class="bi bi-shield-check-fill me-2 text-success"></i>Konfirmasi Password Baru
                                </label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                       class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                       required autocomplete="new-password">
                                @error('new_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary rounded-3">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Kembali
                                </a>

                                <button type="submit" class="btn btn-warning d-flex align-items-center rounded-3">
                                    <i class="bi bi-key-fill me-2"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password strength indicator
        document.getElementById('new_password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength');

            // Remove existing classes
            strengthBar.classList.remove('weak', 'medium', 'strong');

            if (password.length === 0) {
                strengthBar.style.width = '0%';
                return;
            }

            let score = 0;

            // Length check
            if (password.length >= 8) score += 1;
            if (password.length >= 12) score += 1;

            // Character variety checks
            if (/[a-z]/.test(password)) score += 1;
            if (/[A-Z]/.test(password)) score += 1;
            if (/[0-9]/.test(password)) score += 1;
            if (/[^A-Za-z0-9]/.test(password)) score += 1;

            // Determine strength
            if (score < 3) {
                strengthBar.classList.add('weak');
            } else if (score < 5) {
                strengthBar.classList.add('medium');
            } else {
                strengthBar.classList.add('strong');
            }
        });

        // Password confirmation validation
        document.getElementById('new_password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('new_password').value;
            const confirmation = this.value;

            if (confirmation && password !== confirmation) {
                this.setCustomValidity('Password tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
@endsection
