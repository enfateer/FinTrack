@extends('layouts.app')

@section('content')
    <style>
        /* Gaya spesifik disalin dari halaman Kategori untuk konsistensi */
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important; 
        }
        
        /* Baris Tabel */
        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f9fafb; /* Latar belakang halus saat hover */
        }
        
        /* Teks badge */
        .badge.text-success, .badge.text-danger, .badge.bg-secondary {
            font-size: 0.85em;
            padding: 0.4em 0.7em;
            border-radius: 0.5rem;
        }

        /* Warna badge Kategori */
        .badge.bg-secondary {
            background-color: #e9ecef !important;
            color: #495057 !important;
        }

        /* Icon pada badge Jenis */
        .badge.text-success i, .badge.text-danger i {
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
                <i class="bi bi-arrow-left-right me-2 text-primary"></i> Manajemen Transaksi
            </h1>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('transactions.export') }}" class="btn btn-outline-success d-flex align-items-center">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export Excel
                </a>

                <a href="{{ route('transactions.create') }}" class="btn btn-primary d-flex align-items-center">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Transaksi
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3 px-4">Tanggal</th>
                            <th scope="col" class="py-3">Item</th>
                            <th scope="col" class="py-3">Kategori</th>
                            <th scope="col" class="py-3 text-end">Harga</th>
                            <th scope="col" class="py-3 text-center">Jumlah</th>
                            <th scope="col" class="py-3">Jenis</th>
                            <th scope="col" class="py-3 text-end">Total</th>
                            <th scope="col" class="py-3 text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($transactions->count() > 0)
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td class="px-4 text-muted">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                    <td class="fw-semibold">{{ $transaction->item_name }}</td>

                                    <td>
                                        @if($transaction->category)
                                            <span class="badge bg-secondary">
                                                {{ $transaction->category->name }}
                                            </span>
                                        @else
                                            <span class="text-muted fst-italic">Kategori Dihapus</span>
                                        @endif
                                    </td>

                                    <td class="text-end">Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $transaction->quantity }}</td>

                                    <td>
                                        @if($transaction->type == 'pemasukan')
                                            <span class="badge bg-success-subtle text-success fw-semibold">
                                                <i class="bi bi-arrow-down-left"></i> Pemasukan
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger fw-semibold">
                                                <i class="bi bi-arrow-up-right"></i> Pengeluaran
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end fw-bold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('transactions.show', $transaction) }}"
                                                class="btn btn-sm btn-info d-flex align-items-center" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('transactions.edit', $transaction) }}"
                                                class="btn btn-sm btn-primary d-flex align-items-center" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('transactions.destroy', $transaction) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus transaksi {{ $transaction->item_name }}? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger d-flex align-items-center" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i> Belum ada transaksi yang tercatat.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- @if ($transactions->hasPages())
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @endif --}}

    </div>
@endsection