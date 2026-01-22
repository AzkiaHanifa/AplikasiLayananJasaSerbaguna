<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib untuk manajemen file
use Illuminate\Support\Str; // Wajib untuk membuat slug

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori
     */
    public function index()
    {
        // Mengambil data terbaru dengan pagination
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Menampilkan form tambah kategori
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Menyimpan data baru (Store)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string',
            'is_featured' => 'nullable' // Checkbox bisa null atau '1'
        ]);

        // 2. LOGIKA CEK MAX 5 FEATURED
        // Jika user mencentang "Featured", cek dulu kuota di database
        if ($request->has('is_featured')) {
            $countFeatured = Category::where('is_featured', true)->count();
            
            // Jika sudah ada 5 atau lebih, kembalikan error
            if ($countFeatured >= 5) {
                return back()
                    ->withErrors(['is_featured' => 'Maksimal hanya 5 kategori yang boleh di-highlight! Silakan uncheck kategori lain terlebih dahulu.'])
                    ->withInput();
            }
        }

        // 3. Persiapan Data
        $data = $request->except(['icon']); // Ambil semua input kecuali icon
        $data['slug'] = Str::slug($request->name);
        
        // Handle Checkbox: Jika ada request 'is_featured', set true. Jika tidak, false.
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        // 4. Proses Upload Gambar
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('category-icons', 'public');
            $data['icon'] = $path;
        }

        // 5. Simpan ke Database
        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat');
    }

    /**
     * Menampilkan form edit kategori
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Mengupdate data kategori
     */
    public function update(Request $request, Category $category)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string',
            'is_featured' => 'nullable'
        ]);

        // 2. LOGIKA CEK MAX 5 FEATURED
        // Cek hanya jika user ingin mengubah jadi Featured, padahal sebelumnya tidak
        if ($request->has('is_featured') && !$category->is_featured) {
            $countFeatured = Category::where('is_featured', true)->count();
            
            if ($countFeatured >= 5) {
                return back()
                    ->withErrors(['is_featured' => 'Kuota 5 kategori unggulan sudah penuh!'])
                    ->withInput();
            }
        }

        // 3. Persiapan Data
        $data = $request->except(['icon']);
        $data['slug'] = Str::slug($request->name);
        
        // Handle Checkbox
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        // 4. Proses Ganti Gambar (Switchable Icon)
        if ($request->hasFile('icon')) {
            
            // A. Hapus gambar lama jika ada fisiknya
            if ($category->icon && Storage::disk('public')->exists($category->icon)) {
                Storage::disk('public')->delete($category->icon);
            }

            // B. Upload gambar baru
            $path = $request->file('icon')->store('category-icons', 'public');
            $data['icon'] = $path;
        }

        // 5. Update Database
        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $jobs = Job::where('category_id', $category->id)
                    ->latest()
                    ->get();

        return view('landing.kategori', compact('category', 'jobs'));
    }

    /**
     * Menghapus kategori
     */
    public function destroy(Category $category)
    {
        // Hapus gambar dari penyimpanan saat kategori dihapus
        if ($category->icon && Storage::disk('public')->exists($category->icon)) {
            Storage::disk('public')->delete($category->icon);
        }

        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }

    /**
     * METHOD BARU (Ini yang tadi hilang): Toggle Featured
     * Dipanggil saat switch di halaman index diklik.
     */
    public function toggleFeatured(Category $category)
    {
        // Jika status saat ini FALSE, berarti user mau mengubahnya jadi TRUE (Featured).
        // Maka kita harus cek dulu kuota 5.
        // if (!$category->is_featured) {
        //     $countFeatured = Category::where('is_featured', true)->count();
            
        //     if ($countFeatured >= 5) {
        //         // Return dengan session error agar ditangkap oleh alert merah di view index
        //         return back()->with('error', 'Gagal! Maksimal hanya 5 kategori yang boleh di-highlight.');
        //     }
        // }

        // Ubah status (Flip boolean: true jadi false, false jadi true)
        $category->update([
            'is_featured' => !$category->is_featured
        ]);

        $status = $category->is_featured ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Status featured kategori berhasil $status.");
    }
}