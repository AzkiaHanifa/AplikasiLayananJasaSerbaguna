<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\User; // Import Model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk hapus gambar saat update/delete

class JobController extends Controller
{
    /**
     * Menampilkan daftar pekerjaan dengan filter
     */
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

        // Eager load category dan user untuk performa
        $jobs = $query->with(['category', 'user'])->latest()->paginate(10);
        
        $categories = Category::all(); 

        return view('admin.jobs.index', compact('jobs', 'categories'));
    }

    /**
     * Menampilkan form tambah job
     */
    public function create()
    {
        $categories = Category::all();
        $users = User::all(); // <--- AMBIL SEMUA USER UNTUK DIPILIH

        return view('admin.jobs.create', compact('categories', 'users'));
    }

    /**
     * Menyimpan job baru ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'user_id'     => 'required|exists:users,id', // <--- VALIDASI USER ID DARI FORM
            'type'        => 'required|string',
            'location'    => 'required|string',
            'description' => 'required|string',
            'is_job'      => 'required|string',
            'job_image'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // 2. Upload Gambar
        if ($request->hasFile('job_image')) {
            $imagePath = $request->file('job_image')->store('jobs', 'public');
            $validated['job_image'] = $imagePath;
        }

        // 3. Set data lainnya
        // Kita menggunakan input dari form, BUKAN Auth::id()
        $validated['user_id'] = $request->user_id; 
        
        // Handle Checkbox is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // 4. Simpan
        Job::create($validated);
        
        return redirect()->route('admin.jobs.index')->with('success', 'Job baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk edit job
     */
    public function edit(Job $job)
    {
        $categories = Category::all();
        $users = User::all(); // Kita juga butuh list user di halaman edit
        
        return view('admin.jobs.edit', compact('job', 'categories', 'users'));
    }

    /**
     * Mengupdate job di database
     */
    public function update(Request $request, Job $job)
    {
        // 1. Validasi (Gambar jadi nullable karena user mungkin tidak ganti gambar)
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'user_id'     => 'required|exists:users,id', // Bisa ganti pemilik job
            'type'        => 'required|string',
            'location'    => 'required|string',
            'description' => 'required|string',
            'is_job'      => 'required|string',
            'job_image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Cek Upload Gambar Baru
        if ($request->hasFile('job_image')) {
            // Hapus gambar lama jika ada
            if ($job->job_image && Storage::disk('public')->exists($job->job_image)) {
                Storage::disk('public')->delete($job->job_image);
            }
            // Upload baru
            $imagePath = $request->file('job_image')->store('jobs', 'public');
            $validated['job_image'] = $imagePath;
        }

        // 3. Set data lainnya
        $validated['user_id'] = $request->user_id;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // 4. Update
        $job->update($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job berhasil diperbarui!');
    }

    /**
     * Menghapus job dari database
     */
    public function destroy(Job $job)
    {
        // Hapus file gambar fisik agar tidak menumpuk sampah
        if ($job->job_image && Storage::disk('public')->exists($job->job_image)) {
            Storage::disk('public')->delete($job->job_image);
        }

        $job->delete();
        
        return redirect()->route('admin.jobs.index')->with('success', 'Job berhasil dihapus.');
    }
}