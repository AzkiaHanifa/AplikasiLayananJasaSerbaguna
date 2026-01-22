<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Mitra; // <--- PENTING: Wajib ada agar tidak error "Class 'App\Models\Mitra' not found"
use App\Models\TransaksiJasa;
use App\Models\Job;
use Illuminate\Support\Str;
use App\Models\UlasanJasa;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Pastikan file view ada di resources/views/user/home.blade.php
        return view('user.home', compact('user'));
    }

    public function riwayat()
    {
        $userId = Auth::id();
        $transaksi = TransaksiJasa::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return view('user.transaksi.riwayat', compact('transaksi'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        
        // --- BAGIAN INI YANG MEMPERBAIKI ERROR "Undefined variable $mitra" ---
        // Kita cari data mitra milik user yang sedang login
        $mitra = Mitra::where('user_id', $user->id)->first();
        $job = Job::where('user_id', $user->id)->first();

        // Kita kirimkan variabel $user DAN $mitra ke view
        return view('user.profile', compact('user', 'mitra', 'job'));
    }

    public function edit()
    {
        $user = Auth::user();
        // Pastikan file view ada di resources/views/user/edit.blade.php
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update Data Text
        $user->nama = $request->nama;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;

        // Update Foto Profil
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            // Simpan foto baru
            $path = $request->file('foto_profil')->store('profiles', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil berhasil dilengkapi!');
    }

    public function transaksi()
    {
        $transaksi = TransaksiJasa::with('job')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.transaksi.index', compact('transaksi'));
    }


    public function orderJasa(Request $request)
    {
        $request->validate([
            'alamat_tujuan' => 'required|string'
        ]);

        $transaksi = TransaksiJasa::create([
            'job_id' => $request->job_id,
            'user_id' => auth()->id(),
            'kode_transaksi' => 'TRX-' . strtoupper(Str::random(8)),
            'tanggal_transaksi' => Carbon::now(),
            'status' => 'pending',
            'alamat_tujuan' => $request->alamat_tujuan
        ]);

        return redirect('/user/transaksi')
            ->with('success', 'Transaksi berhasil dibuat');
    }

    public function batalOrderJasa($id)
    {
        $transaksi = TransaksiJasa::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (in_array($transaksi->status, ['selesai', 'dibatalkan'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan');
        }

        $transaksi->update([
            'status' => 'dibatalkan'
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi_jasa,id',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ]);

        // Cegah double review
        UlasanJasa::updateOrCreate(
            ['transaksi_jasa_id' => $request->transaksi_id],
            [
                'rating' => $request->rating,
                'ulasan' => $request->ulasan,
            ]
        );

        return back()->with('success', 'Terima kasih atas penilaian Anda 🙏');
    }
}