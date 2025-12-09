<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import ini untuk buat slug

class CategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('admin.categories.create');
    }

    // Menyimpan data (Create)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Description opsional
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Otomatis buat slug dari name
            'description' => $request->description
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat');
    }

    // Menampilkan form edit
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Update data
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Update slug jika nama berubah
            'description' => $request->description
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate');
    }

    // Hapus data
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus');
    }
}