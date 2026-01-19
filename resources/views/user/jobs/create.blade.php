@extends('layouts.user.main')

@section('content')
<br><br><br><br><br><br>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('user.profile') }}" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Kembali ke Profil
            </a>

            <div class="card shadow border-0">
                <div class="card-header p-4">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-megaphone-fill me-2"></i> Pasang Iklan Jasa Baru
                    </h4>
                    <p class="mb-0 small">Tawarkan keahlian Anda kepada calon pelanggan.</p>
                </div>

                <div class="card-body p-4">
                    
                    {{-- Form Start --}}
                    {{-- PENTING: enctype="multipart/form-data" wajib ada untuk upload foto --}}
                    <form action="{{ route('user.jobs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- 1. JUDUL JASA --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Judul Jasa / Pekerjaan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   placeholder="Contoh: Jasa Service AC Panggilan, Tukang Las Listrik"
                                   value="{{ old('title') }}" required>
                            
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. NAMA USAHA / PENYEDIA JASA (YANG SEBELUMNYA HILANG) --}}
                        <div class="mb-3">
                            <label for="company" class="form-label fw-bold">Nama Usaha / Penyedia Jasa <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('company') is-invalid @enderror" 
                                   id="company" 
                                   name="company" 
                                   placeholder="Contoh: Bengkel Maju Jaya, atau Nama Anda Sendiri"
                                   value="{{ old('company') ?? Auth::user()->nama }}" required>
                            
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. FOTO JASA --}}
                        <div class="mb-3">
                            <label for="job_image" class="form-label fw-bold">Foto Sampul / Portfolio</label>
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
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <option value="" selected disabled>-- Pilih Tipe --</option>
                                    <option value="Harian" {{ old('type') == 'Harian' ? 'selected' : '' }}>Harian</option>
                                    <option value="Borongan" {{ old('type') == 'Borongan' ? 'selected' : '' }}>Borongan (Per Proyek)</option>
                                    <option value="Per Jam" {{ old('type') == 'Per Jam' ? 'selected' : '' }}>Per Jam</option>
                                    <option value="Freelance" {{ old('type') == 'Freelance' ? 'selected' : '' }}>Freelance / Kontrak</option>
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
                                       placeholder="Contoh: Bandung Kota, Jakarta Selatan, atau Seluruh Indonesia"
                                       value="{{ old('location') }}" required>
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
                                      placeholder="Jelaskan detail jasa yang Anda tawarkan, pengalaman, alat yang digunakan, dll." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TOMBOL ACTION --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                <i class="bi bi-send-check me-2"></i> Terbitkan Iklan Jasa
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection