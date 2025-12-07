<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditController extends Controller
{
    public function update(Request $request)
{
    $user = Auth::user();

    // Validasi
    $request->validate([
        'nama' => 'required|string|max:255', // Sekarang nama wajib diisi
        'no_hp' => 'required|string|max:15',
        'alamat' => 'required|string',
        'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Update Data Teks
    $user->nama = $request->nama;
    $user->no_hp = $request->no_hp;
    $user->alamat = $request->alamat;

    // Logic Upload Foto
    if ($request->hasFile('foto_profil')) {
        // Hapus foto lama jika bukan null
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }
        // Simpan foto baru
        $path = $request->file('foto_profil')->store('profiles', 'public');
        $user->foto_profil = $path;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profil berhasil dilengkapi!');
}
}
