@extends('layouts.user.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i> Form Pendaftaran Mitra</h5>
                </div>
                <div class="card-body p-4">
                    
                    {{-- Form Upload harus pakai enctype="multipart/form-data" --}}
                    <form action="{{ route('user.mitra.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Input NIK --}}
                        <div class="mb-3">
                            <label for="nik" class="form-label fw-bold">NIK (Nomor Induk Kependudukan)</label>
                            <input type="number" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" placeholder="Masukkan 16 digit NIK">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Alamat --}}
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan alamat domisili lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Foto KTP --}}
                        <div class="mb-4">
                            <label for="foto_ktp" class="form-label fw-bold">Foto KTP</label>
                            <input type="file" name="foto_ktp" id="foto_ktp" class="form-control @error('foto_ktp') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB.</small>
                            @error('foto_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.profile') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i> Kirim Pendaftaran
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection