@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold text-dark">
            <i class="fas fa-trash me-2 text-secondary"></i> Data Sampah - Transaksi
        </h1>
        <a href="{{ route('transactions.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Transaksi
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if($trashedTransactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Item</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Total</th>
                                <th>Dihapus Pada</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trashedTransactions as $transaction)
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
                                    <span class="badge {{ $transaction->type == 'pemasukan' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                <td>{{ $transaction->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <form action="{{ route('transactions.restore', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" title="Pulihkan">
                                                <i class="fas fa-undo me-1"></i> Pulihkan
                                            </button>
                                        </form>
                                        <form action="{{ route('transactions.delete-permanent', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus permanen transaksi ini? Tindakan ini tidak dapat dibatalkan!')"
                                                title="Hapus Permanen">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-trash fa-3x text-secondary mb-3"></i>
                    <h5 class="text-muted">Data sampah kosong</h5>
                    <p class="text-muted">Tidak ada transaksi yang dihapus sementara.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection