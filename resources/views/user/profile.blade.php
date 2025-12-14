@extends('layouts.user.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">

            {{-- ALERT NOTIFIKASI HTML (Backup jika JS gagal) --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- ================= 1. KARTU PROFIL ================= --}}
            <div class="card shadow border-0 overflow-hidden mb-4">
                <div class="card-header bg-primary text-white p-4 text-center">
                    <h4 class="mb-0">Profil Saya</h4>
                </div>

                <div class="card-body p-4">
                    <div class="row align-items-center">
                        {{-- FOTO PROFIL --}}
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="position-relative d-inline-block">
                                @if($user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" class="rounded-circle img-thumbnail shadow-sm" style="width: 180px; height: 180px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ $user->nama ?? $user->email }}&background=random&size=180" class="rounded-circle img-thumbnail shadow-sm">
                                @endif
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-secondary">{{ ucfirst($user->roles) }}</span>
                            </div>
                        </div>

                        {{-- DATA DIRI --}}
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

                            {{-- TOMBOL KEMBALI & EDIT --}}
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <a href="{{ route('user.home') }}" class="btn btn-secondary px-4">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </a>
                                <a href="{{ route('user.profile.edit') }}" class="btn btn-warning px-4 text-white">
                                    <i class="bi bi-pencil-square me-2"></i> Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ================= AKHIR KARTU PROFIL ================= --}}


            {{-- ================= 2. AREA MENU TAMBAHAN (DINAMIS) ================= --}}
            {{-- 
                Logika: 
                - Jika belum daftar mitra ($mitra == null) -> Tampilkan Tombol Daftar.
                - Jika sudah daftar -> Tampilkan Status & Tombol Kelola Jasa.
            --}}
            
            <div class="card shadow border-0 overflow-hidden bg-white mb-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            {{-- LOGIKA JUDUL --}}
                            <h5 class="fw-bold text-primary mb-2">
                                <i class="bi bi-briefcase-fill me-2"></i> 
                                {{ $mitra ? 'Kelola Jasa & Layanan' : 'Ingin Menjadi Mitra Penjasa?' }}
                            </h5>
                            
                            {{-- LOGIKA DESKRIPSI & STATUS --}}
                            <p class="text-muted mb-0">
                                @if(!$mitra)
                                    Bergabunglah bersama kami dan tawarkan jasa Anda.
                                @else
                                    @if($mitra->status == 'pending')
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Status Mitra: Menunggu Verifikasi</span>
                                    @elseif($mitra->status == 'rejected')
                                        <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Status Mitra: Ditolak</span>
                                    @else
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Status Mitra: Aktif</span>
                                        <br>Kelola penawaran jasa Anda di sini.
                                    @endif
                                @endif
                            </p>
                        </div>

                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            
                            @if(!$mitra)
                                {{-- KONDISI 1: BELUM DAFTAR MITRA --}}
                                <a href="{{ route('user.mitra.register') }}" class="btn btn-primary px-4 py-2 shadow-sm rounded-pill">
                                    Daftar Sekarang <i class="bi bi-arrow-right ms-2"></i>
                                </a>

                            @else
                                {{-- KONDISI 2: SUDAH ADA DATA MITRA (Cek Status via JS onclick) --}}
                                <button onclick="checkMitraAccess('{{ $mitra->status }}', '{{ route('user.jobs.manage') }}')" 
                                        class="btn btn-success px-4 py-2 shadow-sm rounded-pill">
                                    <i class="bi bi-gear-fill me-2"></i> Kelola Jasa
                                </button>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            
            {{-- ================= AKHIR AREA MENU TAMBAHAN ================= --}}

        </div>
    </div>
</div>

{{-- 
    =======================================================
    SCRIPT (SWEETALERT & LOGIC AKSES)
    =======================================================
--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // FUNGSI 1: CEK STATUS AKSES MITRA
    function checkMitraAccess(status, url) {
        if (status === 'pending') {
            Swal.fire({
                icon: 'info',
                title: 'Sedang Ditinjau',
                text: 'Pendaftaran Mitra Anda sedang diverifikasi oleh Admin. Mohon tunggu persetujuan sebelum mengelola jasa.',
                confirmButtonColor: '#3085d6',
            });
        } else if (status === 'rejected') {
            Swal.fire({
                icon: 'error',
                title: 'Pendaftaran Ditolak',
                text: 'Maaf, pengajuan Mitra Anda ditolak. Silakan hubungi admin untuk info lebih lanjut.',
                confirmButtonColor: '#d33',
            });
        } else if (status === 'approved') {
            // Jika Approved, baru pindah halaman
            window.location.href = url;
        }
    }

    // FUNGSI 2: MENANGKAP SESSION FLASHDATA
    document.addEventListener("DOMContentLoaded", function() {
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33',
                confirmButtonText: 'Tutup'
            });
        @endif

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke'
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#f39c12',
                confirmButtonText: 'Mengerti'
            });
        @endif

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: "{{ session('info') }}",
                confirmButtonColor: '#3085d6'
            });
        @endif
    });
</script>
@endsection