<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{
    // --- FUNGSI INI YANG HILANG SEBELUMNYA ---
    public function create()
    {
        // Cek jika user sudah pernah daftar (Opsional)
        // Sesuaikan 'partners' dengan nama tabel Anda jika berbeda
        $existingMitra = Mitra::where('user_id', Auth::id())->first();
        
        if ($existingMitra) {
            return redirect()->route('user.profile')->with('error', 'Anda sudah mendaftar sebagai mitra.');
        }

        // Arahkan ke view pendaftaran
        // Pastikan file view ada di: resources/views/user/partner/register.blade.php
        return view('user.mitra.register'); 
    }
    // ------------------------------------------

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|unique:mitra,nik',
            'alamat' => 'required|string',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_ktp')) {
            $path = $request->file('foto_ktp')->store('ktp_images', 'public');
        }

        // Simpan ke database
        // Pastikan nama Model (Partner/Mitra) sesuai dengan yang Anda buat
        Mitra::create([
            'user_id' => Auth::id(),
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'foto_ktp' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('user.profile')->with('success', 'Pendaftaran berhasil dikirim!');
    }
}