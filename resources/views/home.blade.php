@extends('layouts.app')

@section('content')
    <style>
        /* Gaya Konsistensi disalin dari halaman lain */
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
            /* Konsisten dengan halaman lain */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        }

        /* Peningkatan Gaya Card Summary */
        .summary-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
        }

        /* Ikon di Card Summary */
        .summary-card .icon-circle {
            background: rgba(255, 255, 255, 0.2);
            padding: 12px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
        }

        /* Badge pada tabel Recent Transactions */
        .recent-badge {
            font-size: 0.8em;
            padding: 0.4em 0.7em;
            border-radius: 0.5rem;
        }

        /* Table Hover */
        .table-hover tbody tr:hover {
            background-color: #f9fafb !important;
        }
    </style>

    <div class="container py-4 fade-in-up">

        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body py-4">
                <h1 class="h4 fw-bold text-dark mb-1">
                    <i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard FinTrack
                </h1>
                <p class="text-muted mb-0">
                    Selamat datang kembali, <b>{{ Auth::user()->name }} !!</b> Pantau ringkasan keuangan Anda di sini.
                </p>
            </div>
        </div>

        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card border-0 text-white rounded-3 shadow-sm bg-success summary-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="small text-white-75 fw-semibold mb-1">TOTAL PEMASUKAN</p>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                        </div>
                        <div class="icon-circle">
                            <i class="bi bi-arrow-down-left fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 text-white rounded-3 shadow-sm bg-danger summary-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="small text-white-75 fw-semibold mb-1">TOTAL PENGELUARAN</p>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
                        </div>
                        <div class="icon-circle">
                            <i class="bi bi-arrow-up-right fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 text-white rounded-3 shadow-sm bg-primary summary-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="small text-white-75 fw-semibold mb-1">SALDO SAAT INI</p>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                        </div>
                        <div class="icon-circle">
                            <i class="bi bi-wallet-fill fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body">

                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-lightning-fill me-2 text-warning"></i> Akses Cepat
                </h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('transactions.create') }}"
                            class="btn btn-primary rounded-3 w-100 d-flex justify-content-between align-items-center py-3">
                            <span class="fw-semibold">Tambah Transaksi Baru</span>
                            <i class="bi bi-plus-circle-fill fs-5"></i> </a>
                    </div>

                    <div class="col-md-6">
                        <a href="{{ route('categories.create') }}"
                            class="btn btn-success rounded-3 w-100 d-flex justify-content-between align-items-center py-3">
                            <span class="fw-semibold">Tambah Kategori Baru</span>
                            <i class="bi bi-tags-fill fs-5"></i> </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row g-4">

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="bi bi-pie-chart-fill me-2 text-info"></i> Frekuensi Transaksi
                        </h5>

                        <div class="d-flex justify-content-center align-items-center" style="height:250px;">
                            <div style="width:200px; height:200px;">
                                <canvas id="transactionChart"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-0 pb-0 pt-3">
                        <h5 class="fw-bold text-dark mb-2">
                            <i class="bi bi-clock-history me-2 text-secondary"></i> Transaksi Terbaru
                        </h5>
                        <a href="{{ route('transactions.index') }}"
                            class="text-primary text-decoration-none fw-semibold small">
                            Lihat Semua Transaksi <i class="bi bi-arrow-right-circle-fill ms-1"></i>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3">Item</th>
                                    <th class="py-3">Kategori</th>
                                    <th class="py-3">Jenis</th>
                                    <th class="py-3 text-end">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($recentTransactions as $transaction)
                                    <tr>
                                        <td class="px-4 text-muted">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                        <td class="fw-semibold">{{ $transaction->item_name }}</td>
                                        <td>
                                            @if($transaction->category)
                                                <span class="badge bg-secondary-subtle text-secondary recent-badge">
                                                    {{ $transaction->category->name }}
                                                </span>
                                            @else
                                                <span class="text-muted fst-italic">Kategori Dihapus</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->type == 'pemasukan')
                                                <span class="badge bg-success-subtle text-success recent-badge fw-semibold">
                                                    <i class="bi bi-arrow-down-left"></i> Pemasukan
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger recent-badge fw-semibold">
                                                    <i class="bi bi-arrow-up-right"></i> Pengeluaran
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end fw-bold">
                                            @if($transaction->type == 'pemasukan')
                                                <span class="text-success">+ Rp
                                                    {{ number_format($transaction->total, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-danger">- Rp
                                                    {{ number_format($transaction->total, 0, ',', '.') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <i class="bi bi-exclamation-circle-fill me-2"></i> Belum ada transaksi terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pastikan variabel JavaScript tetap ada untuk inisialisasi Chart.js
        window.countPemasukan = {{ $countPemasukan }};
        window.countPengeluaran = {{ $countPengeluaran }};

        // Chart untuk frekuensi transaksi
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('transactionChart');
            if (ctx) {
                const countPemasukan = window.countPemasukan || 0;
                const countPengeluaran = window.countPengeluaran || 0;

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Pemasukan', 'Pengeluaran'],
                        datasets: [{
                            data: [countPemasukan, countPengeluaran],
                            backgroundColor: [
                                'rgba(25, 135, 84, 0.8)',  // hijau untuk pemasukan
                                'rgba(220, 53, 69, 0.8)'   // merah untuk pengeluaran
                            ],
                            borderColor: [
                                'rgba(25, 135, 84, 1)',
                                'rgba(220, 53, 69, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                        return `${label}: ${value} kali (${percentage}%)`;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                },
                                formatter: function(value, context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                    return `${value}\n(${percentage}%)`;
                                },
                                textAlign: 'center'
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection