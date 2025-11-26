<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Memproses registrasi
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // Membuat user baru
        $user = User::create([
            'nama'     => $validated['nama'],
            'password' => Hash::make($validated['password']),
        ]);

  

        return redirect('/login')->with('success', 'Registrasi berhasil');
    }
}
