@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Banner</h6>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    
                    {{-- Tampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Wajib untuk Update --}}

                        {{-- Input Judul --}}
                        <div class="mb-4">
                            <label class="font-weight-bold">Judul Banner</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}">
                        </div>

                        {{-- Preview Gambar Lama --}}
                        <div class="mb-3">
                            <label class="font-weight-bold d-block">Gambar Saat Ini:</label>
                            <img src="{{ asset('storage/' . $banner->image) }}" class="img-fluid rounded shadow-sm border" style="max-height: 200px;">
                        </div>

                        {{-- Input Gambar Baru --}}
                        <div class="mb-4">
                            <label class="font-weight-bold">Ganti Gambar (Opsional)</label>
                            <input type="file" name="image" class="form-control-file border p-2 w-100">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection