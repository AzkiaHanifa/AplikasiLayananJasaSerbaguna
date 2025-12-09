@extends('layouts.admin.admin') 

@section('content')
<div class="container-fluid">
    
    {{-- Judul dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Kategori</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Kategori --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Kategori</th>
                            <th>Slug</th> {{-- Opsional, jika menggunakan slug --}}
                            <th style="width: 15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td class="text-center">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Tombol Hapus (Form) --}}
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                            <td colspan="4" class="text-center">Belum ada data kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                {{-- Pagination (jika pakai paginate di controller) --}}
                <div class="mt-3">
                    {{ $categories->links() }} 
                </div>
            </div>
        </div>
    </div>

</div>
@endsection