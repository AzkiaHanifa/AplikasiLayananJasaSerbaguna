@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow border-0 overflow-hidden">
                {{-- Header Card --}}
                <div class="card-header bg-primary text-white p-4 text-center">
                    <h4 class="mb-0">Profil Saya</h4>
                </div>

                <div class="card-body p-4">
                    <div class="row align-items-center">
                        
                        {{-- KOLOM KIRI: FOTO PROFIL --}}
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="position-relative d-inline-block">
                                @if($user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                                         class="rounded-circle img-thumbnail shadow-sm"
                                         style="width: 180px; height: 180px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ $user->nama ?? $user->email }}&background=random&size=180" 
                                         class="rounded-circle img-thumbnail shadow-sm">
                                @endif
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-secondary">{{ ucfirst($user->roles) }}</span>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: DATA DIRI --}}
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th class="ps-0 text-muted" width="35%">Nama Lengkap</th>
                                        <td class="fw-bold fs-5">{{ $user->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0 text-muted">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0 text-muted">No. Handphone</th>
                                        <td>{{ $user->no_hp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0 text-muted">Alamat</th>
                                        <td>{{ $user->alamat ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0 text-muted">Bergabung Sejak</th>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- BAGIAN TOMBOL --}}
                            {{-- Gunakan justify-content-between agar tombol terpisah (Kiri & Kanan) --}}
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                
                                {{-- Tombol Kembali (Di Kiri) --}}
                                <a href="{{ route('user.home') }}" class="btn btn-secondary px-4">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </a>

                                {{-- Tombol Edit (Di Kanan) --}}
                                <a href="{{ route('user.profile.edit') }}" class="btn btn-warning px-4 text-white">
                                    <i class="bi bi-pencil-square me-2"></i> Edit Profil
                                </a>

                            </div>
                            {{-- Akhir Bagian Tombol --}}

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection