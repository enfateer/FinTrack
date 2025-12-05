<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Exports\TransactionsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['category', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('transactions.index', compact('transactions'));
    }

    public function export()
    {
        return Excel::download(new TransactionsExport, 'transactions_' . date('Y-m-d') . '.xlsx');
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $category = Category::find($request->category_id);

        Transaction::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'type' => $category->type,
            'transaction_date' => $request->transaction_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function eksporPdf($id)
    {
        $transaction = Transaction::with(['category', 'user'])->findOrFail($id);

        // if ($transaction->user_id !== auth()->id() && !auth()->user()->is_admin) {
        //     abort(403, 'Unauthorized action.');
        // }

        $pdf = Pdf::loadView('transactions.export-pdf', compact('transaction'));
        return $pdf->download('transaction_' . $transaction->id . '_' . date('Y-m-d') . '.pdf');
    }

    public function show($id)
    {
        $transaction = Transaction::with(['category', 'user'])->findOrFail($id);

        if ($transaction->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        return view('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $category = Category::find($request->category_id);

        $transaction->update([
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'type' => $category->type,
            'transaction_date' => $request->transaction_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
