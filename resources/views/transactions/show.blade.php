@extends('layouts.app')

@section('content')
    <div class="container py-4 fade-in-up">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h4 fw-bold text-dark mb-0">
                        <i class="fas fa-eye me-2 text-primary"></i> Detail Transaksi
                    </h1>

                    <!-- Buttons grouped -->
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <a href="{{ route('transactions.export_pdf', $transaction) }}" class="btn btn-success">
                            <i class="fas fa-download me-2"></i> Ekspor PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <!-- Transaction Date -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Tanggal Transaksi</label>
                            <p class="form-control-plaintext fs-5">{{ $transaction->transaction_date->format('d F Y') }}</p>
                        </div>
                    </div>

                    <!-- Item Name -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Nama Barang/Jasa</label>
                            <p class="form-control-plaintext fs-5">{{ $transaction->item_name }}</p>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Kategori</label>
                            <p class="form-control-plaintext">
                                @if($transaction->category)
                                    <span class="badge bg-secondary fs-6">{{ $transaction->category->name }}</span>
                                @else
                                    <span class="text-muted">Kategori Dihapus</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Jenis Transaksi</label>
                            <p class="form-control-plaintext">
                                @if($transaction->type == 'pemasukan')
                                    <span class="badge bg-success-subtle text-success fw-semibold fs-6">
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger fw-semibold fs-6">
                                        Pengeluaran
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Harga Satuan</label>
                            <p class="form-control-plaintext fs-5">Rp {{ number_format($transaction->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Jumlah</label>
                            <p class="form-control-plaintext fs-5">{{ $transaction->quantity }}</p>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Total Transaksi</label>
                            <p class="form-control-plaintext fs-5 fw-bold text-primary">Rp
                                {{ number_format($transaction->total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($transaction->notes)
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Catatan</label>
                                <p class="form-control-plaintext">{{ $transaction->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Created/Updated Info -->
                    <div class="col-12">
                        <div class="alert alert-light border">
                            <small class="text-secondary">
                                <i class="fas fa-info-circle me-2"></i>
                                Dibuat pada: <strong>{{ $transaction->created_at->format('d F Y, H:i') }}</strong>
                                @if($transaction->updated_at != $transaction->created_at)
                                    | Diubah pada: <strong>{{ $transaction->updated_at->format('d F Y, H:i') }}</strong>
                                @endif
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                {{-- <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i> Edit
                    </a>
                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i> Hapus
                        </button>
                    </form>
                </div> --}}
            </div>
        </div>
    </div>
@endsection