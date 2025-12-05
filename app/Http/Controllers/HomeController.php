<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Hitung total & saldo
        $pemasukan = Transaction::where('user_id', $userId)->where('type', 'pemasukan');
        $pengeluaran = Transaction::where('user_id', $userId)->where('type', 'pengeluaran');

        $totalPemasukan = $pemasukan->sum('total');
        $totalPengeluaran = $pengeluaran->sum('total');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Hitung jumlah transaksi
        $countPemasukan = $pemasukan->count();
        $countPengeluaran = $pengeluaran->count();

        // 5 transaksi terakhir
        $recentTransactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Ringkasan bulanan
        $monthlySummary = Transaction::select(
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('YEAR(transaction_date) as year'),
                DB::raw('SUM(CASE WHEN type = "pemasukan" THEN total ELSE 0 END) as pemasukan'),
                DB::raw('SUM(CASE WHEN type = "pengeluaran" THEN total ELSE 0 END) as pengeluaran')
            )
            ->where('user_id', $userId)
            ->whereYear('transaction_date', date('Y'))
            ->groupBy('year', 'month')
            ->get();

        return view('home', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'countPemasukan',
            'countPengeluaran',
            'recentTransactions',
            'monthlySummary'
        ));
    }
}
