<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserJobController extends Controller
{
    // Halaman Form Tambah Jasa
    public function create()
    {
        $user = Auth::user();
        
        // 1. Ambil data mitra dari user yang sedang login
        // Pastikan di Model User sudah ada: public function mitra() { return $this->hasOne(Mitra::class); }
        $mitra = $user->mitra;

        // 2. Cek jika user BELUM mendaftar mitra sama sekali
        if (!$mitra) {
            return redirect()->route('user.mitra.register')
                ->with('error', 'Anda harus mendaftar sebagai Mitra terlebih dahulu untuk membuka jasa.');
        }

        // 3. Cek Status: PENDING
        if ($mitra->status == 'pending') {
            // Menggunakan 'warning' agar SweetAlert di view Anda warnanya kuning
            return redirect()->back()
                ->with('warning', 'Akun Mitra Anda masih dalam proses verifikasi (Pending). Mohon tunggu persetujuan Admin.');
        }

        // 4. Cek Status: REJECTED
        if ($mitra->status == 'rejected') {
            return redirect()->back()
                ->with('error', 'Mohon maaf, pengajuan Mitra Anda ditolak. Silakan hubungi admin atau perbaiki data.');
        }

        // 5. Lolos semua cek (Berarti status == 'approved') -> Tampilkan Form
        $categories = Category::all(); // Ambil kategori untuk dropdown
        return view('user.jobs.create', compact('categories'));
    }

    // Proses Simpan Data Jasa
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location'    => 'required|string',
            'type'        => 'required|string', // Misal: Harian, Borongan, dll
        ]);

        Job::create([
            'user_id'     => Auth::id(), // Otomatis ambil ID user yang login
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'company'     => Auth::user()->nama, // Bisa nama user atau nama toko mitra
            'description' => $request->description,
            'location'    => $request->location,
            'type'        => $request->type,
            'is_active'   => 1, // Default aktif
        ]);

        return redirect()->route('user.profile')->with('success', 'Jasa Anda berhasil diterbitkan!');
    }
}