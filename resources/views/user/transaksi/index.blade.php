@extends('layouts.user.main')

@section('content')
<br><br><br><br><br><br>
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="fw-bold">📄 Riwayat Transaksi</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($transaksi as $item)
        <div class="card shadow-sm border mb-2">
            <div class="card-body">
                @if ($item->status == 'pending')
                    <div class="alert alert-info">
                        Tunggu Jasa menerima pesanan anda
                    </div>
                @endif
                <div class="row align-items-center">

                    {{-- JOB INFO --}}
                    <div class="col-md-4">
                        <h5 class="fw-semibold mb-1">
                            {{ $item->job->title ?? 'Jasa' }}
                        </h5>
                        <small class="text-muted">
                            Kode: {{ $item->kode_transaksi }}
                        </small>
                    </div>

                    {{-- TANGGAL --}}
                    <div class="col-md-2 text-md-start mt-3 mt-md-0">
                        <small class="text-muted d-block">Tanggal</small>
                        <span class="fw-semibold">
                            {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}

                        </span>
                    </div>

                    {{-- TOTAL --}}
                    <div class="col-md-4 text-md-start mt-3 mt-md-0">
                        <small class="text-muted d-block">Alamat Tujuan</small>
                        <span class="fw-bold text-primary">
                            {{ $item->alamat_tujuan }}
                        </span>
                    </div>

                    {{-- STATUS --}}
                    <div class="col-md text-md-center mt-3 mt-md-0">
                        <span class="badge rounded-pill 
                            @if($item->status == 'pending') bg-secondary
                            @elseif($item->status == 'menunggu_pembayaran') bg-warning
                            @elseif($item->status == 'dibayar') bg-info
                            @elseif($item->status == 'diproses') bg-primary
                            @elseif($item->status == 'selesai') bg-success
                            @else bg-danger
                            @endif">
                            {{ ucfirst(str_replace('_',' ', $item->status)) }}
                        </span>
                    </div>

                </div>
                @if ($item->status == 'pending')
                    <form action="{{ url('/user/transaksi/batalkan/' . $item->id) }}" 
                        method="POST"
                        onsubmit="return confirm('Apakah anda yakin ingin membatalkan pesanan ini?')">
                        
                        @csrf
                        
                        <button type="submit" class="mt-2 btn btn-outline-danger rounded-pill">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif
              
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="120" class="mb-3">
            <h6 class="text-muted">Belum ada transaksi</h6>
        </div>
    @endforelse

</div>
@endsection
