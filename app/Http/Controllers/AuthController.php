<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

     public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=> 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // redirect berdasarkan roles
            switch ($user->roles) {
                case 'admin':
                    return redirect('/admin/dashboard');

                case 'user':
                    return redirect('/');

                case 'mitra':
                    return redirect('/');

                default:
                    Auth::logout();
                    return redirect('/login')->with('error', 'Role tidak dikenali');
            }
        }

        return back()->with('error', 'Login gagal, cek kembali username/password');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}