@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold text-dark mb-0">Sampah Kategori</h1>
            <a href="{{ route('categories.index') }}" class="btn btn-primary d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Kategori
            </a>
        </div>

        <!-- Categories Trash Table -->
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Nama Kategori</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Dihapus Pada</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if($category->type == 'pemasukan')
                                        <span class="badge bg-success-subtle text-success fw-semibold">
                                            {{ $category->type }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger fw-semibold">
                                            {{ $category->type }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $category->deleted_at->format('d M Y, H:i') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('categories.restore', $category->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan kategori {{ $category->name }}?')"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success"
                                                title="Kembalikan">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('categories.delete-permanent', $category->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen kategori ini?')"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Hapus Permanen">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Tidak ada kategori di sampah</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
