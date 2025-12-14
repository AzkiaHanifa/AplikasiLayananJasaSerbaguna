@extends('layouts.user.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('user.profile') }}" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Kembali ke Profil
            </a>

            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark p-4">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i> Edit Iklan Jasa
                    </h4>
                    <p class="mb-0 small text-dark-50">Perbarui informasi jasa Anda agar tetap relevan.</p>
                </div>

                <div class="card-body p-4">
                    
                    {{-- Form Start --}}
                    {{-- Action mengarah ke user.jobs.update dengan ID job --}}
                    <form action="{{ route('user.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- PENTING: Untuk mengubah method POST menjadi PUT --}}

                        {{-- 1. JUDUL JASA --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Judul Jasa / Pekerjaan <span class="text-danger">*</span></label>
                            {{-- Value mengambil dari old input (jika gagal validasi) ATAU data database ($job->title) --}}
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $job->title) }}" required>
                            
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. NAMA USAHA / PENYEDIA JASA --}}
                        <div class="mb-3">
                            <label for="company" class="form-label fw-bold">Nama Usaha / Penyedia Jasa <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('company') is-invalid @enderror" 
                                   id="company" 
                                   name="company" 
                                   value="{{ old('company', $job->company) }}" required>
                            
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. FOTO JASA --}}
                        <div class="mb-3">
                            <label for="job_image" class="form-label fw-bold">Foto Sampul / Portfolio</label>
                            
                            {{-- Tampilkan Foto Lama Jika Ada --}}
                            @if($job->job_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $job->job_image) }}" alt="Foto Jasa" class="img-thumbnail" style="max-height: 200px">
                                    <div class="small text-muted fst-italic mt-1">*Foto saat ini. Biarkan kosong jika tidak ingin mengubah.</div>
                                </div>
                            @endif

                            <input type="file" 
                                   class="form-control @error('job_image') is-invalid @enderror" 
                                   id="job_image" 
                                   name="job_image" 
                                   accept="image/*">
                            <div class="form-text text-muted">
                                Format: JPG, PNG, JPEG. Maksimal Ukuran: 2MB.
                            </div>

                            @error('job_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- 4. KATEGORI --}}
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="" disabled>-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        {{-- Logic Selected: Cek apakah ID kategori cocok dengan data job --}}
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 5. TIPE JASA --}}
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-bold">Tipe Penawaran <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="" disabled>-- Pilih Tipe --</option>
                                    <option value="Harian" {{ old('type', $job->type) == 'Harian' ? 'selected' : '' }}>Harian</option>
                                    <option value="Borongan" {{ old('type', $job->type) == 'Borongan' ? 'selected' : '' }}>Borongan (Per Proyek)</option>
                                    <option value="Per Jam" {{ old('type', $job->type) == 'Per Jam' ? 'selected' : '' }}>Per Jam</option>
                                    <option value="Freelance" {{ old('type', $job->type) == 'Freelance' ? 'selected' : '' }}>Freelance / Kontrak</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- 6. LOKASI --}}
                        <div class="mb-3">
                            <label for="location" class="form-label fw-bold">Lokasi / Area Layanan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location', $job->location) }}" required>
                            </div>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 7. DESKRIPSI --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Deskripsi Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="6" 
                                      required>{{ old('description', $job->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TOMBOL ACTION --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold text-white">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection