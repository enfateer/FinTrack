@extends('layouts.app')

@section('content')
    <style>
        /* Gaya spesifik untuk halaman ini */
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

        /* Peningkatan Gaya Kartu dan Tabel */
        .card.shadow-sm {
            border-radius: 0.75rem;
            /* Pembulatan sudut kartu yang lebih jelas */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
            /* Shadow yang lebih lembut */
        }

        /* Baris Tabel */
        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
            /* Latar belakang halus saat hover */
        }

        /* Teks badge */
        .badge.text-success,
        .badge.text-danger {
            font-size: 0.85em;
            padding: 0.4em 0.7em;
            border-radius: 0.5rem;
        }

        /* Icon pada badge */
        .badge.text-success i,
        .badge.text-danger i {
            margin-right: 5px;
        }

        /* Tombol Aksi */
        .btn-sm {
            padding: 0.4rem 0.75rem;
            border-radius: 0.5rem;
        }
    </style>

    <div class="container py-4 fade-in-up">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold text-dark mb-0">
                <i class="bi bi-tags-fill me-2 text-primary"></i> Manajemen Kategori
            </h1>

            <div class="d-flex justify-content-end align-items-center gap-2">

                <a href="{{ route('categories.export') }}" class="btn btn-outline-success d-flex align-items-center">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export Excel
                </a>

                <a href="{{ route('categories.trash') }}" class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="bi bi-archive-fill me-2"></i> Sampah Kategori
                </a>

                <a href="{{ route('categories.create') }}" class="btn btn-primary d-flex align-items-center">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Kategori
                </a>
            </div>
        </div>

        {{-- @include('components.alert') --}}


        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3 px-4">Nama Kategori</th>
                            <th scope="col" class="py-3">Jenis</th>
                            <th scope="col" class="py-3 text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="px-4 fw-semibold">{{ $category->name }}</td>
                                <td>
                                    @if($category->type == 'pemasukan')
                                        <span class="badge bg-success-subtle text-success fw-semibold">
                                            <i class="bi bi-arrow-down-left"></i> {{ $category->type }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger fw-semibold">
                                            <i class="bi bi-arrow-up-right"></i> {{ $category->type }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="btn btn-sm btn-primary d-flex align-items-center" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i> Belum ada kategori yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- @if ($categories->hasPages())
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
        @endif --}}

    </div>
@endsection