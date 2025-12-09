@extends('layouts.admin.admin') {{-- Pastikan ini sesuai layout Anda --}}

@section('content')
{{-- PENTING: Tetap menggunakan 'container' agar ukuran lebar tetap sama dengan kode asli User Anda --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            {{-- Bagian Header & Tombol (Mengikuti style design Kategori tapi layout tetap rapi) --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                {{-- Judul dengan style heading yang sama dengan Kategori --}}
                <h1 class="h3 mb-0 text-gray-800">Manajemen User</h1>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- CARD SHADOW (Design baru) --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        {{-- TABLE STRIPED & DARK HEADER (Design baru) --}}
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    {{-- Lebar kolom disesuaikan agar proporsional --}}
                                    <th style="width: 5%">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Terdaftar</th>
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        {{-- Pastikan $user->roles sesuai dengan nama kolom/relasi di database Anda --}}
                                        <td>{{ $user->roles ?? '-' }}</td> 
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            
                                            {{-- MENGGUNAKAN IKON (Design baru) --}}
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form onsubmit="return confirm('Apakah Anda Yakin ingin menghapus user ini?');" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data User belum tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection