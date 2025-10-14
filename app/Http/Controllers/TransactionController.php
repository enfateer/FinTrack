<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['category', 'user'])
            ->latest()
            ->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:pemasukan,pengeluaran',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Gunakan create dengan data yang sudah divalidasi
        Transaction::create([
            'user_id' => auth()->id(), // Tambahkan user_id secara manual
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'type' => $request->type,
            'transaction_date' => $request->transaction_date,
            'notes' => $request->notes,
            // total akan dihitung otomatis di model boot method
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaction $transaction)
    {
        // Pastikan user hanya bisa melihat transaksi miliknya sendiri
        if ($transaction->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        // Pastikan user hanya bisa mengedit transaksi miliknya sendiri
        if ($transaction->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Pastikan user hanya bisa mengupdate transaksi miliknya sendiri
        if ($transaction->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:pemasukan,pengeluaran',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $transaction->update([
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'type' => $request->type,
            'transaction_date' => $request->transaction_date,
            'notes' => $request->notes,
            // total akan dihitung otomatis di model boot method
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        // Pastikan user hanya bisa menghapus transaksi miliknya sendiri
        if ($transaction->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}