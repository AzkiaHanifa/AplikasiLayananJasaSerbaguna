<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;      // Import Model Job
use App\Models\Category; // Import Model Category (PENTING untuk Tab Filter)

class LandingController extends Controller
{
    /**
     * Menampilkan halaman utama website (Root).
     */
    public function index()
    {
        // 1. Ambil data jobs (Jasa)
        // - with('category'): Eager load relasi category agar query lebih cepat/ringan
        // - where('is_active', true): Hanya tampilkan job yang statusnya aktif
        // - latest(): Urutkan dari yang paling baru dibuat
        $jobs = Job::with('category')
                    ->where('is_active', true)
                    ->latest()
                    ->get();

        // 2. Ambil semua data categories
        // Data ini Wajib ada karena digunakan untuk looping judul Tab (Vegetables, Fruits, dll) di view landing
        $categories = Category::all();

        // 3. Kirim kedua variable ($jobs dan $categories) ke view 'landing'
        return view('landing.index', compact('jobs', 'categories'));
    }
    public function show($id)
    {
        // Ambil data job berdasarkan ID, sertakan relasi category dan user (pemilik jasa)
        // findOrFail berfungsi jika ID tidak ditemukan akan otomatis 404
        $job = Job::with(['category', 'user'])->findOrFail($id);

        // Arahkan ke view detail
        return view('landing.show', compact('job'));
    }
} // End Class
