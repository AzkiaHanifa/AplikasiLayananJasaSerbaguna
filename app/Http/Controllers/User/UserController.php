<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Mitra; // <--- PENTING: Wajib ada agar tidak error "Class 'App\Models\Mitra' not found"

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Pastikan file view ada di resources/views/user/home.blade.php
        return view('user.home', compact('user'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        
        // --- BAGIAN INI YANG MEMPERBAIKI ERROR "Undefined variable $mitra" ---
        // Kita cari data mitra milik user yang sedang login
        $mitra = Mitra::where('user_id', $user->id)->first();

        // Kita kirimkan variabel $user DAN $mitra ke view
        return view('user.profile', compact('user', 'mitra'));
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
}