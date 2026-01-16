@extends('layouts.admin.admin') 

@section('content')
<div class="container-fluid">
    
    {{-- 1. HEADER: Judul dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Kategori</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    {{-- 2. ALERTS: Menampilkan Pesan Sukses atau Error --}}
    
    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Alert Error (PENTING: Muncul jika kuota featured > 5) --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- 3. TABEL DATA --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%" class="text-center">No</th>
                            <th style="width: 10%" class="text-center">Ikon</th> 
                            <th>Nama Kategori</th>
                            {{-- KOLOM BARU: FEATURED --}}
                            <th style="width: 15%" class="text-center">Diunggulkan</th> 
                            <th style="width: 15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            {{-- No --}}
                            <td class="align-middle text-center">{{ $loop->iteration + $categories->firstItem() - 1 }}</td>
                            
                            {{-- Icon --}}
                            <td class="align-middle text-center">
                                @if($category->icon)
                                    <img src="{{ asset('storage/' . $category->icon) }}" 
                                         alt="Icon" 
                                         class="img-fluid rounded" 
                                         style="max-height: 40px; max-width: 40px; object-fit: contain;">
                                @else
                                    <span class="badge bg-secondary">No Icon</span>
                                @endif
                            </td>

                            {{-- Nama & Slug --}}
                            <td class="align-middle">
                                <span class="fw-bold">{{ $category->name }}</span>
                                <br>
                                <small class="text-muted"><i class="fas fa-link"></i> {{ $category->slug }}</small>
                            </td>
                            
                            {{-- TOGGLE FEATURED (Form Switch) --}}
                            <td class="align-middle text-center">
                                <form action="{{ route('admin.categories.toggle', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               name="is_featured" 
                                               onchange="this.form.submit()" 
                                               {{ $category->is_featured ? 'checked' : '' }}
                                               style="cursor: pointer; transform: scale(1.3);">
                                    </div>
                                </form>
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center align-middle">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                Belum ada data kategori.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-end">
                    {{ $categories->links() }} 
                </div>
            </div>
        </div>
    </div>

</div>
@endsection