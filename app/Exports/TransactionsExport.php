<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Transaction::with(['category', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Item',
            'Kategori',
            'Harga',
            'Jumlah',
            'Tipe',
            'Total',
            'Catatan'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_date->format('d/m/Y'),
            $transaction->item_name,
            $transaction->category ? $transaction->category->name : 'Kategori Dihapus',
            'Rp ' . number_format($transaction->price, 0, ',', '.'),
            $transaction->quantity,
            $transaction->type,
            'Rp ' . number_format($transaction->total, 0, ',', '.'),
            $transaction->notes ?? '-'
        ];
    }
}
