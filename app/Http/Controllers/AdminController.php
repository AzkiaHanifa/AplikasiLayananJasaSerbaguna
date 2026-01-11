<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Mengambil jumlah data menggunakan Eloquent count()
        // Ini sangat ringan query-nya karena hanya menghitung baris
        $totalJobs = Job::count();
        $totalCategories = Category::count();
        $totalUsers = User::count(); 
        
        // Opsional: Jika ingin menghitung user selain admin (misal role 'user')
        // $totalUsers = User::where('role', 'user')->count();

        // 2. Kirim data ke view menggunakan compact
        return view('admin.dashboard', compact('totalJobs', 'totalCategories', 'totalUsers'));
    }
}
