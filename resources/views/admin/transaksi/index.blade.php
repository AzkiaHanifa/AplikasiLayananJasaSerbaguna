@extends('layouts.admin.admin') 

@section('content')
<div class="container-fluid">
    
    {{-- 1. HEADER: Judul dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
    </div>

    {{-- 2. ALERTS: Menampilkan Pesan Sukses atau Error --}}
    
    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Alert Error (PENTING: Muncul jika kuota featured > 5) --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- 3. TABEL DATA --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%" class="text-center">No</th>
                            <th style="width: 10%" class="text-center">Kode Transaksi</th> 
                            <th>Tanggal</th>
                            {{-- KOLOM BARU: FEATURED --}}
                            <th style="width: 15%" class="text-center">Status</th> 
                            <th style="width: 15%" class="text-center">Jasa</th> 
                            <th style="width: 15%" class="text-center">Pelanggan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse($transaksi as $item)
                        <tr>
                            {{-- No --}}
                            <td class="align-middle text-center">{{ $no++ }}</td>

                            {{-- Nama & Slug --}}
                            <td class="align-middle">
                                <span class="fw-bold">{{ $item->kode_transaksi }}</span>
                            </td>
                            <td class="align-middle">
                                <span >{{ $item->tanggal_transaksi }}</span>
                            </td>
                            <td class="align-middle">
                                <span >{{ $item->status }}</span>
                            </td>
                            <td class="align-middle">
                                <span >{{ $item->job->title }}</span>
                            </td>
                            <td class="align-middle">
                                <span >{{ $item->user->nama }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                Belum ada data kategori.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-end">
                    {{ $transaksi->links() }} 
                </div>
            </div>
        </div>
    </div>

</div>
@endsection