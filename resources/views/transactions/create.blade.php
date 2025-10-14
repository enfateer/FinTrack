@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 fw-bold text-dark mb-4">
                <i class="fas fa-plus-circle me-2 text-primary"></i> Tambah Transaksi Baru
            </h1>

            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf

                <div class="row g-3">
                    <!-- Item Name -->
                    <div class="col-12">
                        <label for="item_name" class="form-label fw-semibold">Nama Barang/Jasa</label>
                        <input type="text" id="item_name" name="item_name" value="{{ old('item_name') }}"
                            class="form-control @error('item_name') is-invalid @enderror" required>
                        @error('item_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-semibold">Kategori</label>
                        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->type }})
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold">Jenis Transaksi</label>
                        <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">Pilih Jenis</option>
                            <option value="pemasukan" {{ old('type') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="pengeluaran" {{ old('type') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold">Harga Satuan</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"
                            class="form-control @error('price') is-invalid @enderror" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div class="col-md-6">
                        <label for="quantity" class="form-label fw-semibold">Jumlah</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                            class="form-control @error('quantity') is-invalid @enderror" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Transaction Date -->
                    <div class="col-md-6">
                        <label for="transaction_date" class="form-label fw-semibold">Tanggal Transaksi</label>
                        <input type="date" id="transaction_date" name="transaction_date" 
                            value="{{ old('transaction_date', date('Y-m-d')) }}"
                            class="form-control @error('transaction_date') is-invalid @enderror" required>
                        @error('transaction_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label for="notes" class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea id="notes" name="notes" rows="3" 
                            class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary d-flex align-items-center">
                        <i class="fas fa-save me-2"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
