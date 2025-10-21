<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
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

        Category::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $categories = Category::find($id);
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

    $updateCategories = Category::where('id', $id)->update([
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
        $category = Category::find($id);

        // Cek apakah kategori sudah digunakan dalam transaksi
        if ($category->transactions()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }

        $deleteCategories = $category->delete();
        if ($deleteCategories) {
            return redirect()->route('categories.index')->with('success', 'Data kategori berhasil dihapus permanen');
        } else {
            return redirect()->back()->with('failed', 'Data kategori gagal dihapus');
        }
    }


}