<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiJasa;
use Illuminate\Support\Facades\Storage; // Penting untuk hapus/upload foto

class UserJobController extends Controller
{
    /**
     * 1. GATEKEEPER (PENGATUR ALUR)
     * Method ini dipanggil saat tombol "Kelola Jasa" diklik.
     * Logika: Jika sudah punya jasa -> Edit. Jika belum -> Create.
     */
    public function listOrder()
    {
        $userId = Auth::id();
        $jasa = Job::where('user_id', $userId)->first();
        // Cek apakah user ini SUDAH punya jasa
        $transaksi = TransaksiJasa::where('job_id', $jasa->id)->orderBy('created_at', 'desc')->get();
        return view('user.jobs.list-order', compact('transaksi'));
    }

    public function manage()
    {
        $userId = Auth::id();
        
        // Cek apakah user ini SUDAH punya jasa
        $job = Job::where('user_id', $userId)->first();

        if ($job) {
            // JIKA SUDAH ADA -> Arahkan ke halaman EDIT
            // Pastikan route 'user.jobs.edit' sudah ada di web.php
            return redirect()->route('user.jobs.edit', $job->id);
        } else {
            // JIKA BELUM ADA -> Arahkan ke halaman CREATE
            return redirect()->route('user.jobs.create');
        }
    }

    /**
     * 2. FORM CREATE
     * Menampilkan form pembuatan jasa baru.
     * Dilengkapi validasi Status Mitra.
     */
    public function create()
    {
        $user = Auth::user();

        // --- CEK 1: APAKAH SUDAH PUNYA JASA? (Strict Mode) ---
        if (Job::where('user_id', $user->id)->exists()) {
            return redirect()->route('user.jobs.manage')
                ->with('warning', 'Anda hanya bisa memiliki satu profil jasa.');
        }
        
        // --- CEK 2: STATUS MITRA ---
        // Ambil data mitra (Pastikan relasi hasOne ada di Model User)
        $mitra = $user->mitra;

        // Jika belum daftar mitra
        if (!$mitra) {
            return redirect()->route('user.mitra.register')
                ->with('error', 'Anda harus mendaftar sebagai Mitra terlebih dahulu.');
        }

        // Jika status Pending
        if ($mitra->status == 'pending') {
            return redirect()->route('user.profile')
                ->with('warning', 'Akun Mitra Anda masih menunggu verifikasi Admin.');
        }

        // Jika status Rejected
        if ($mitra->status == 'rejected') {
            return redirect()->route('user.profile')
                ->with('error', 'Mohon maaf, pengajuan Mitra Anda ditolak.');
        }

        // --- LOLOS SEMUA CEK (Status Approved) ---
        $categories = Category::all();
        return view('user.jobs.create', compact('categories'));
    }

    /**
     * 3. PROSES SIMPAN (STORE)
     * Menyimpan data jasa baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255', // Nama Usaha/Jasa
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location'    => 'required|string',
            'type'        => 'required|string', // Fulltime/Freelance/Harian
            'job_image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi Foto
        ]);

        // 2. Upload Foto (Jika ada)
        $imagePath = null;
        if ($request->hasFile('job_image')) {
            $imagePath = $request->file('job_image')->store('job_images', 'public');
        }

        // 3. Simpan ke Database
        Job::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'company'     => $request->company,
            'description' => $request->description,
            'location'    => $request->location,
            'is_job'      => 'tidak tersedia',
            'type'        => $request->type,
            'job_image'   => $imagePath,
            'is_active'   => 1, // Default langsung aktif
        ]);

        // 4. Redirect kembali ke profil
        return redirect()->route('user.profile')->with('success', 'Jasa Anda berhasil diterbitkan!');
    }

    /**
     * 4. FORM EDIT (Tambahan Wajib)
     * Karena method manage() mengarahkan ke edit, maka fungsi ini harus ada.
     */
    public function edit($id)
    {
        $job = Job::findOrFail($id);

        // Pastikan yang edit adalah pemilik jasa
        if ($job->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('user.jobs.edit', compact('job', 'categories'));
    }

    /**
     * 5. PROSES UPDATE (Tambahan Wajib)
     * Untuk menyimpan perubahan data jasa.
     */
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        // Validasi pemilik
        if ($job->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'category_id' => 'required',
            'description' => 'required',
            'location'    => 'required',
            'type'        => 'required',
            'job_image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Logic Update Foto
        if ($request->hasFile('job_image')) {
            // Hapus foto lama jika ada
            if ($job->job_image && Storage::disk('public')->exists($job->job_image)) {
                Storage::disk('public')->delete($job->job_image);
            }
            // Upload foto baru
            $imagePath = $request->file('job_image')->store('job_images', 'public');
            $job->job_image = $imagePath;
        }

        // Update Data Text
        $job->update([
            'title'       => $request->title,
            'company'     => $request->company,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'location'    => $request->location,
            'type'        => $request->type,
            // job_image sudah dihandle diatas
        ]);

        return redirect()->route('user.profile')->with('success', 'Data Jasa berhasil diperbarui!');
    }

    public function toggleStatus($id, Request $request)
    {
        $job = Job::findOrFail($id);
        $job->is_job = $request->status;
        $job->save();

        return redirect('/user/profile')->with(
            'success',
            'Status jasa berhasil diubah'
        );
    }

    public function tolakTransaksi($id)
    {
        $transaksi = TransaksiJasa::findOrFail($id);
        if (in_array($transaksi->status, ['selesai', 'ditolak'])) {
            return back()->with('error', 'Pesanan tidak dapat ditolak');
        };
        $transaksi->status = 'ditolak';
        $transaksi->save();
        
        return back()->with('success', 'Pesanan berhasil ditolak');
    }
    
    public function terimaTransaksi($id)
    {
        
        
        $transaksi = TransaksiJasa::findOrFail($id);
        if (in_array($transaksi->status, ['selesai', 'diterima'])) {
            return back()->with('error', 'Pesanan tidak dapat diterima');
        }
        $transaksi->status = 'diterima';
        $transaksi->save();

        return back()->with('success', 'Pesanan berhasil diterima');
    }

}