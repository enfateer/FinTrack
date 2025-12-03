<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - {{ $transaction->item_name }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .detail-row { margin-bottom: 10px; }
        .label { font-weight: bold; display: inline-block; width: 200px; }
        .value { display: inline-block; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-danger { background-color: #f8d7da; color: #721c24; }
        .badge-secondary { background-color: #e2e3e5; color: #383d41; }
        .total { font-weight: bold; color: #007bff; }
        .alert { background-color: #f8f9fa; padding: 10px; border: 1px solid #dee2e6; border-radius: 4px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detail Transaksi</h1>
        <p>FinTrack PC - Sistem Manajemen Keuangan</p>
    </div>
    <div class="content">
        <div class="detail-row">
            <span class="label">Tanggal Transaksi:</span>
            <span class="value">{{ $transaction->transaction_date->format('d F Y') }}</span>
        </div>

        <div class="detail-row">
            <span class="label">Nama Barang/Jasa:</span>
            <span class="value">{{ $transaction->item_name }}</span>
        </div>

        <div class="detail-row">
            <span class="label">Kategori:</span>
            <span class="value">
                @if($transaction->category)
                    <span class="badge badge-secondary">{{ $transaction->category->name }}</span>
                @else
                    <span>Kategori Dihapus</span>
                @endif
            </span>
        </div>

        <div class="detail-row">
            <span class="label">Jenis Transaksi:</span>
            <span class="value">
                @if($transaction->type == 'pemasukan')
                    <span class="badge badge-success">Pemasukan</span>
                @else
                    <span class="badge badge-danger">Pengeluaran</span>
                @endif
            </span>
        </div>

        <div class="detail-row">
            <span class="label">Harga Satuan:</span>
            <span class="value">Rp {{ number_format($transaction->price, 0, ',', '.') }}</span>
        </div>

        <div class="detail-row">
            <span class="label">Jumlah:</span>
            <span class="value">{{ $transaction->quantity }}</span>
        </div>

        <div class="detail-row">
            <span class="label">Total Transaksi:</span>
            <span class="value total">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
        </div>

        @if($transaction->notes)
        <div class="detail-row">
            <span class="label">Catatan:</span>
            <span class="value">{{ $transaction->notes }}</span>
        </div>
        @endif

        <div class="alert">
            Dibuat pada: {{ $transaction->created_at->format('d F Y, H:i') }}
            @if($transaction->updated_at != $transaction->created_at)
                | Diubah pada: {{ $transaction->updated_at->format('d F Y, H:i') }}
            @endif
        </div>
    </div>
</body>
</html>
