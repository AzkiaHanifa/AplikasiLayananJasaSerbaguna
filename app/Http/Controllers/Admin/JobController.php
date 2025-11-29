<?php

namespace App\Http\Controllers\Admin; // Namespace harus menyertakan 'Admin'

use App\Http\Controllers\Controller; // <-- INI PENTING! Mengimport class Controller dari folder induk
use App\Models\Job; 
use App\Models\Category;
use Illuminate\Http\Request;
class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::query();
        
        // --- LOGIKA FILTER KATEGORI ---
        if ($request->has('category') && $request->category != 'all') {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // --- LOGIKA FILTER KEYWORD ---
        if ($request->has('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        $jobs = $query->latest()->paginate(10);
        
        // Ambil semua kategori untuk ditampilkan di filter menu
        $categories = Category::all(); 

        return view('admin.jobs.index', compact('jobs', 'categories')); // <--- Kirim juga categories ke view
    }

   public function create()
{
    $categories = Category::all();
    return view('admin.jobs.create', compact('categories'));
}

/** Menyimpan job baru ke database */
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id', // Validasi kategori harus ada
        'type' => 'required|string',
        'location' => 'required|string',
        'is_active' => 'boolean',
    ]);
    
    Job::create($validated);
    
    return redirect()->route('admin.jobs.index')->with('success', 'Job baru berhasil ditambahkan!');
}

/** Menampilkan form untuk edit job */
public function edit(Job $job)
{
    $categories = Category::all();
    return view('admin.jobs.edit', compact('job', 'categories'));
}

/** Mengupdate job di database */
public function update(Request $request, Job $job)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id', 
        'type' => 'required|string',
        'location' => 'required|string',
        'is_active' => 'boolean',
    ]);

    $job->update($validated);

    return redirect()->route('admin.jobs.index')->with('success', 'Job berhasil diperbarui!');
}

/** Menghapus job dari database */
public function destroy(Job $job)
{
    $job->delete();
    
    return redirect()->route('admin.jobs.index')->with('success', 'Job berhasil dihapus.');
}
}