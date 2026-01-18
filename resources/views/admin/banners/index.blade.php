@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Kelola Banner Utama</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Tambah Banner</div>
                <div class="card-body">
                    @if($banners->count() < 3)
                        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Judul (Opsional)</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Upload Gambar (Ukuran rekomendasi: 1920x600 px)</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Upload Banner</button>
                        </form>
                    @else
                        <div class="alert alert-warning text-center mb-0">
                            <strong>Slot Penuh!</strong><br>
                            Hapus salah satu banner untuk menambah yang baru.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">Daftar Banner ({{ $banners->count() }}/3)</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($banners as $banner)
                                <tr>
                                    <td width="40%">
                                        <img src="{{ asset('storage/' . $banner->image) }}" class="img-fluid rounded" style="max-height: 100px;">
                                    </td>
                                    <td>{{ $banner->title ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Yakin hapus banner ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @if($banners->isEmpty())
                                    <tr><td colspan="3" class="text-center">Belum ada banner.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection