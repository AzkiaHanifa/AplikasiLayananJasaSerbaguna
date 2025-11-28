<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        
        // UBAH DARI: 'user.profile.index'
        // MENJADI: 'user.profile' (karena nama filenya profile.blade.php di folder user)
        return view('user.profile', compact('user'));
    }
    public function edit()
    {
        $user = Auth::user();
        // Pastikan file view ada di resources/views/user/profile/edit.blade.php
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

        // Update Text
        $user->nama = $request->nama;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;

        // Update Foto
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            // Simpan baru
            $path = $request->file('foto_profil')->store('profiles', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil berhasil dilengkapi!');
    }
}