<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Exports\CategoriesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
            ->whereNull('deleted_at')
            ->get();
        return view('categories.index', compact('categories'));
    }

    public function export()
    {
        return Excel::download(new CategoriesExport, 'categories_' . date('Y-m-d') . '.xlsx');
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $categories = Category::where('user_id', auth()->id())->find($id);
        if (!$categories) {
            abort(404);
        }
        return view('categories.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
            'description' => 'nullable|string',
        ],
    [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'type.required' => 'Tipe kategori wajib diisi.',
            'type.in' => 'Tipe kategori harus berupa "pemasukan" atau "pengeluaran".',
            'description.string' => 'Deskripsi harus berupa teks.',
    ]);

    $updateCategories = Category::where('id', $id)
        ->where('user_id', auth()->id())
        ->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        if ($updateCategories) {
            return redirect()->route('categories.index')->with('success', 'Data kategori berhasil diupdate');
        } else {
            return redirect()->back()->with('failed', 'Data kategori gagal diupdate');
        }

        // $category->update($request->all());

        // return redirect()->route('categories.index')
        //     ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = Category::where('user_id', auth()->id())->find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        // Cek apakah kategori sudah digunakan dalam transaksi
        if ($category->transactions()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }

        $deleteCategories = $category->delete(); // Soft delete
        if ($deleteCategories) {
            return redirect()->route('categories.index')->with('success', 'Data kategori berhasil dihapus');
        } else {
            return redirect()->back()->with('failed', 'Data kategori gagal dihapus');
        }
    }

    public function trash()
    {
        $categories = Category::where('user_id', auth()->id())
            ->onlyTrashed()
            ->get();
        return view('categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::where('user_id', auth()->id())
            ->withTrashed()
            ->find($id);
        if ($category) {
            $category->restore();
            return redirect()->route('categories.trash')->with('success', 'Kategori berhasil dikembalikan.');
        }
        return redirect()->route('categories.trash')->with('error', 'Kategori tidak ditemukan.');
    }

    public function deletePermanent($id)
    {
        $category = Category::withTrashed()->find($id);
        if ($category) {
            $category->forceDelete();
            return redirect()->route('categories.trash')->with('success', 'Kategori berhasil dihapus permanen.');
        }
        return redirect()->route('categories.trash')->with('error', 'Kategori tidak ditemukan.');
    }


}