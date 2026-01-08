<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi HANYA Email & Password
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Create User (Name dikosongkan/null)
        $user = User::create([
            'nama' => null, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => 'user', // Default role
        ]);

        // 3. Login & Redirect
        Auth::login($user);
        
        // Arahkan ke home user
        return redirect('/');
    }
}