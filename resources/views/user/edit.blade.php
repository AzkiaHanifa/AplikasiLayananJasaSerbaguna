@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Edit Profil</h4>
                </div>
                <div class="card-body">
                    
                    {{-- Form Mulai --}}
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- Preview Foto --}}
                        <div class="mb-4 text-center">
                            <img id="preview" 
                                 src="{{ $user->foto_profil ? asset('storage/'.$user->foto_profil) : 'https://ui-avatars.com/api/?name='.$user->email }}" 
                                 class="rounded-circle mb-2" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            <br>
                            <input type="file" name="foto_profil" class="form-control form-control-sm w-50 mx-auto" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                        </div>

                        {{-- Input Nama --}}
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                        </div>

                        {{-- Input No HP --}}
                        <div class="mb-3">
                            <label>Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}" required>
                        </div>

                        {{-- Input Alamat --}}
                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.home') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </form>
                    {{-- Form Selesai --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection