@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <br><br>
    <!-- resources/views/admin/dashboard.blade.php -->
    <h1>Selamat Datang di Dashboard Admin</h1>

    <div style="margin-top: 30px; border: 1px solid #ddd; padding: 20px;">
        <h2>Menu Utama Job Management</h2>
        <p>Akses cepat untuk mengelola lowongan pekerjaan.</p>
        
        <!-- Tombol menuju Job List Index -->
        <a href="{{ route('admin.jobs.index') }}" 
        style="display: inline-block; padding: 10px 15px; background-color: #3490dc; color: white; text-decoration: none; border-radius: 5px; margin-right: 15px;">
            Lihat & Kelola Daftar Pekerjaan (Index)
        </a>

        <!-- Tombol menuju Form Tambah Job -->
        <a href="{{ route('admin.jobs.create') }}" 
        style="display: inline-block; padding: 10px 15px; background-color: #1c7430; color: white; text-decoration: none; border-radius: 5px;">
            + Tambah Lowongan Baru (Create)
        </a>

    </div>

    <div style="margin-top: 30px; border: 1px solid #ddd; padding: 20px;">
        <h2>Menu Lain</h2>
        <ul>
            <li><a href="#">Kelola Kategori (Belum dibuat)</a></li>
            <li><a href="#">Lihat Pengguna Terdaftar (Belum dibuat)</a></li>
        </ul>
    </div>
</div>
@endsection