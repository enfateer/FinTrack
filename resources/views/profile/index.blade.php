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

        .profile-picture-preview {
            width: 100px; 
            height: 100px; 
            object-fit: cover;
            border: 3px solid var(--bs-light); /* Menambahkan border sedikit tebal */
        }
    </style>

    <div class="container py-4 fade-in-up">

        <div class="row justify-content-center">
            <div class="col-lg-8"> <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h1 class="h4 fw-bold text-dark mb-4 border-bottom pb-3">
                            <i class="bi bi-person-fill-gear me-2 text-primary"></i> Edit Profile
                        </h1>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">

                                <div class="col-12">
                                    <div class="card border-0 bg-light-subtle shadow-sm"> <div class="card-body">

                                            <h6 class="fw-bold mb-3 text-dark">
                                                <i class="bi bi-image-fill me-2 text-secondary"></i> Foto Profile
                                            </h6>

                                            <div class="d-flex align-items-start">

                                                <div class="me-4 flex-shrink-0">
                                                    <img src="{{ $user->profile_picture_url }}"
                                                         class="rounded-circle profile-picture-preview"
                                                         alt="Profile Picture Preview">
                                                </div>

                                                <div class="flex-grow-1">

                                                    <div class="mb-3">
                                                        <label for="profile_picture" class="form-label fw-semibold">Upload Foto Baru</label>
                                                        <input type="file" name="profile_picture" id="profile_picture"
                                                               class="form-control @error('profile_picture') is-invalid @enderror"
                                                               accept="image/jpeg,image/png,image/jpg,image/gif">
                                                        @error('profile_picture')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <small class="text-muted">
                                                            Format: JPEG, PNG, JPG, GIF (Max. 2 MB)
                                                        </small>
                                                    </div>

                                                    @if($user->profile_picture)
                                                    <div class="form-check pt-2">
                                                        <input class="form-check-input" type="checkbox" name="remove_picture" id="remove_picture">
                                                        <label for="remove_picture" class="form-check-label text-danger fw-semibold">
                                                            <i class="bi bi-trash-fill me-1"></i> Hapus foto profile
                                                        </label>
                                                    </div>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4">

                                    <h6 class="fw-bold mb-3 text-dark border-bottom pb-2">
                                        <i class="bi bi-info-circle-fill me-2 text-info"></i> Informasi Dasar
                                    </h6>

                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                                        <input type="text" name="name" id="name"
                                               value="{{ old('name', $user->name) }}"
                                               class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" name="email" id="email"
                                               value="{{ old('email', $user->email) }}"
                                               class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="alert alert-primary border-0 rounded-3 py-2">
                                        <small class="text-primary fw-semibold">
                                            <i class="bi bi-calendar-check-fill me-2"></i>
                                            Terdaftar sejak: **{{ $user->created_at->format('d F Y') }}**
                                        </small>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end gap-3 pt-3 mt-4 border-top">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-3">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Kembali
                                </a>

                                <a href="{{ route('profile.password') }}" class="btn btn-warning rounded-3">
                                    <i class="bi bi-key-fill me-2"></i>
                                    Ganti Password
                                </a>

                                <button type="submit" class="btn btn-primary d-flex align-items-center rounded-3">
                                    <i class="bi bi-floppy-fill me-2"></i>
                                    Update Profile
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

<script>
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.profile-picture-preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    });

    // Menangani logika nonaktifkan input file saat Hapus Foto dicentang
    const removePictureCheckbox = document.getElementById('remove_picture');
    if (removePictureCheckbox) {
        removePictureCheckbox.addEventListener('change', function(e) {
            document.getElementById('profile_picture').disabled = e.target.checked;
        });
    }
</script>
@endsection