@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            {{-- Bagian Header & Tombol Tambah --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard Admin - List Lowongan</h1>
                <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Job Baru
                </a>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- CARD SHADOW --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Lowongan Pekerjaan</h6>
                </div>

                <div class="card-body">
                    
                    {{-- Bagian Filter & Pencarian (Di-styling ulang agar rapi) --}}
                    <form method="GET" action="{{ route('admin.jobs.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="category" class="form-label fw-bold small text-secondary">Kategori</label>
                                <select name="category" id="category" class="form-control form-select">
                                    <option value="all">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" 
                                            {{ request('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="keyword" class="form-label fw-bold small text-secondary">Keyword</label>
                                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Cari Judul..." value="{{ request('keyword') }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        {{-- TABLE STRIPED & DARK HEADER --}}
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Judul & Perusahaan</th>
                                    <th>Kategori</th>
                                    <th>Tipe & Lokasi</th>
                                    <th class="text-center">Status</th>
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $job->title }}</span><br>
                                        <small class="text-muted"><i class="fas fa-building"></i> {{ $job->company }}</small>
                                    </td>
                                    <td>
                                        <span >{{ $job->category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        {{ $job->type }} <br>
                                        <small class="text-muted">({{ $job->location }})</small>
                                    </td>
                                    <td class="text-center">
                                        @if($job->is_active)
                                            <span class="badge bg-success">AKTIF</span>
                                        @else
                                            <span class="badge bg-danger">TUTUP</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
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
                                    <td colspan="6" class="text-center py-3">Belum ada data pekerjaan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection