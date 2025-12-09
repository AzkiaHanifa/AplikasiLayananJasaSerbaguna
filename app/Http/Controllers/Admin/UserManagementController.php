<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        // Mengambil data user, diurutkan terbaru, 10 per halaman
        $users = User::latest()->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan data user baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // butuh field password_confirmation di view
            // 'role' => 'required' // Uncomment jika ada kolom role
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail user (Opsional, jarang dipakai di admin panel simpel)
     */
    public function show(string $id)
    {
        // Biasanya dikosongkan atau redirect ke edit
    }

    /**
     * Menampilkan form edit user
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update data user di database
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            // Validasi email unik kecuali untuk user ini sendiri
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed', // Nullable: boleh kosong jika tidak ganti pass
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            // 'role' => $request->role,
        ];

        // Cek apakah password diisi? Jika iya, hash dan masukkan ke array data
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}