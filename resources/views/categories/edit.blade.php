@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 fw-bold text-dark mb-4">
                <i class="fas fa-edit me-2 text-primary"></i> Edit Kategori
            </h1>

            <form action="{{route('categories.update', $categories->id)}}" method="post">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Category Name -->
                    <div class="col-12">
                        <label for="name" class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $categories->name) }}"
                            class="form-control @error('name') is-invalid @enderror" 
                            placeholder="Masukkan nama kategori" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold">Jenis Kategori</label>
                        <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">Pilih Jenis</option>
                            <option value="pemasukan" {{ old('type', $categories->type) == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="pengeluaran" {{ old('type', $categories->type) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <!-- Description -->
                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">Deskripsi (Opsional)</label>
                        <textarea id="description" name="description" rows="3" 
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Masukkan deskripsi kategori">{{ old('description', $categories->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary d-flex align-items-center">
                        <i class="fas fa-save me-2"></i> Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection