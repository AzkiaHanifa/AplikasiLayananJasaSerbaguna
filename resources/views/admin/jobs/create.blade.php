@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid">
    
    <h1 class="h3 mb-4 text-gray-800">Tambah Job Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Input</h6>
        </div>
        <div class="card-body">
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.jobs.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Judul (Title) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Perusahaan (Company) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="company" value="{{ old('company') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi (Description) <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="5" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Lokasi (Location) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="location" value="{{ old('location') }}" required>
                        </div>

                    </div>

                    <div class="col-md-4">
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Pilih User (Pemilik) <span class="text-danger">*</span></label>
                            <select class="form-control" name="user_id" required>
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Siapa pemilik postingan ini?</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control" name="category_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                         <label class="form-label font-weight-bold">Tipe Pekerjaan <span class="text-danger">*</span></label>
                        <select class="form-control" name="type" required>
                        <option value="">-- Pilih Tipe --</option>

                        <option value="Harian" {{ old('type') == 'Harian' ? 'selected' : '' }}>Harian</option>
                        <option value="Borongan" {{ old('type') == 'Borongan' ? 'selected' : '' }}>Borongan(Per Proyek)</option>
                        <option value="Freelance" {{ old('type') == 'Freelance' ? 'selected' : '' }}>Freelance/Kontrak</option>
                        <option value="Per Jam" {{ old('type') == 'Per Jam' ? 'selected' : '' }}>Per Jam</option>
                         </select>
                            </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Status Ketersediaan <span class="text-danger">*</span></label>
                            <select class="form-control" name="is_job">
                                <option value="tidak tersedia" {{ old('is_job', 'tidak tersedia') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                <option value="tersedia" {{ old('is_job') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Gambar (Job Image) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control-file border p-2 w-100" name="job_image" required>
                            <small class="text-muted">Max: 2MB</small>
                        </div>

                        <div class="form-check mb-4 bg-light p-3 border rounded">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label font-weight-bold" for="is_active">
                                Aktif (Publikasikan)
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary btn-block">Batal</a>

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection