@extends('layouts.admin.admin') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Verifikasi Permohonan Mitra</h5>
                    <span class="badge bg-light text-primary">Pending: {{ $mitras->count() }}</span>
                </div>

                <div class="card-body">
                    {{-- 1. Notifikasi Flash Message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- 2. Tabel Data Mitra --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Info User</th>
                                    <th>Detail Mitra (NIK & Alamat)</th>
                                    <th>Bukti KTP</th>
                                    <th>Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mitras as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    
                                    {{-- Mengambil data dari relasi USER --}}
                                    <td>
                                        <strong>{{ $item->user->nama ?? 'Nama tidak ditemukan' }}</strong><br>
                                        <small class="text-muted">{{ $item->user->email ?? '-' }}</small><br>
                                        <small class="text-muted">{{ $item->user->no_hp ?? '-' }}</small>
                                    </td>

                                    {{-- Mengambil data dari tabel MITRA --}}
                                    <td>
                                        <div><strong>NIK:</strong> {{ $item->nik }}</div>
                                        <div class="text-muted small">{{ Str::limit($item->alamat, 50) }}</div>
                                    </td>

                                    {{-- Menampilkan Foto KTP (Jika ada) --}}
                                    <td class="text-center">
                                        @if($item->foto_ktp)
                                            {{-- Asumsi foto disimpan di storage/public/ktp --}}
                                            <a href="{{ asset('storage/' . $item->foto_ktp) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                Lihat Foto
                                            </a>
                                        @else
                                            <span class="text-muted small">Tidak ada foto</span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Tombol TERIMA (Approve) --}}
                                            <form action="{{ route('admin.mitra.approve', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENERIMA mitra ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm" title="Terima Mitra">
                                                    Checklist (ACC)
                                                </button>
                                            </form>

                                            {{-- Tombol TOLAK (Reject) --}}
                                            <form action="{{ route('admin.mitra.reject', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK mitra ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Tolak Mitra">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            Belum ada permohonan mitra baru yang menunggu verifikasi.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection