@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h1 class="h3 fw-bold text-dark">Dashboard</h1>
            <p class="text-muted mb-0">
                Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Kelola keuangan Anda di sini.
            </p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Pemasukan -->
        <div class="col-md-4">
            <div class="card border-success-subtle shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-success small fw-semibold mb-1">TOTAL PEMASUKAN</p>
                        <h4 class="fw-bold text-success mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                    </div>
                    <i class="fas fa-arrow-down text-success fs-2"></i>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="col-md-4">
            <div class="card border-danger-subtle shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-danger small fw-semibold mb-1">TOTAL PENGELUARAN</p>
                        <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
                    </div>
                    <i class="fas fa-arrow-up text-danger fs-2"></i>
                </div>
            </div>
        </div>

        <!-- Saldo -->
        <div class="col-md-4">
            <div class="card border-primary-subtle shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-primary small fw-semibold mb-1">SALDO SAAT INI</p>
                        <h4 class="fw-bold text-primary mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                    </div>
                    <i class="fas fa-wallet text-primary fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold text-dark mb-3">Quick Actions</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary w-100 d-flex justify-content-between align-items-center">
                        <span>Tambah Transaksi Baru</span>
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('categories.create') }}" class="btn btn-success w-100 d-flex justify-content-between align-items-center">
                        <span>Tambah Kategori Baru</span>
                        <i class="fas fa-tag"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">Transaksi Terbaru</h5>
                <a href="{{ route('transactions.index') }}" class="text-primary text-decoration-none small">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Item</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Jenis</th>
                            <th scope="col" class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                            <td>{{ $transaction->item_name }}</td>
                            <td>
                                @if($transaction->category)
                                    {{ $transaction->category->name }}
                                @else
                                    <span class="text-muted">- Kategori Dihapus -</span>
                                @endif
                            </td>
                            <td>
                                @if($transaction->type == 'pemasukan')
                                    <span class="badge bg-success-subtle text-success fw-semibold">{{ ucfirst($transaction->type) }}</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger fw-semibold">{{ ucfirst($transaction->type) }}</span>
                                @endif
                            </td>
                            <td class="text-end">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection