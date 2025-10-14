<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $totalPemasukan = Transaction::where('type', 'pemasukan')->sum('total');
        $totalPengeluaran = Transaction::where('type', 'pengeluaran')->sum('total');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $recentTransactions = Transaction::with('category')
            ->latest()
            ->take(5)
            ->get();

        $monthlySummary = Transaction::select(
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('YEAR(transaction_date) as year'),
                DB::raw('SUM(CASE WHEN type = "pemasukan" THEN total ELSE 0 END) as pemasukan'),
                DB::raw('SUM(CASE WHEN type = "pengeluaran" THEN total ELSE 0 END) as pengeluaran')
            )
            ->whereYear('transaction_date', date('Y'))
            ->groupBy('year', 'month')
            ->get();

        return view('home', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'recentTransactions',
            'monthlySummary'
        ));
    }
}