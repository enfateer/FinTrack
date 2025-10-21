@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold text-dark mb-0">Manajemen Transaksi</h1>
            <div class="d-flex">
                <a href="{{ route('transactions.create') }}" class="btn btn-primary d-flex align-items-center me-2">
                    <i class="fas fa-plus me-2"></i> Tambah Transaksi
                </a>
                <a href="#" class="btn btn-danger d-flex align-items-center">
                    <i class="fa-solid fa-trash me-2"></i> Sampah Transaksi
                </a>
            </div>
        </div>


        <!-- Transactions Table -->
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Item</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Total Barang</th>
                            <th scope="col">Type</th>
                            <th scope="col" class="text-end">Total Transaksi</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
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
                                <td>Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>
                                    @if($transaction->type == 'pemasukan')
                                        <span class="badge bg-success-subtle text-success fw-semibold">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger fw-semibold">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('transactions.edit', $transaction) }}"
                                            class="btn btn-sm btn-outline-success" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection