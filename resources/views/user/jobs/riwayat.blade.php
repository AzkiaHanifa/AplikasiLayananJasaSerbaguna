@extends('layouts.user.main')

@section('content')
<br><br><br><br><br><br>
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="fw-bold">Riwayat</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($transaksi as $item)
    @if ($item->status == 'selesai' || $item->status == 'dibatalkan')
        <div class="card shadow-sm border mb-3">
            <div class="card-body">
                @if ($item->status == 'pending')
                    <div class="alert alert-info">
                        Tunggu Jasa menerima pesanan anda
                    </div>
                @endif
                <div class="row align-items-center">

                    {{-- JOB INFO --}}
                    <div class="col-md-4">
                        <div class="text-primary">Customer : {{$item->user->nama}}</div>
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
                        <small class="text-muted d-block">Catatan</small>
                        <span class="fw-bold text-primary">
                            {{ $item->alamat_tujuan }}
                        </span>
                    </div>
                    
                    {{-- STATUS --}}
                    <div class="col-md text-md-center mt-3 mt-md-0">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge rounded-pill 
                            @if($item->status == 'pending') bg-secondary
                            @elseif($item->status == 'diterima') bg-info
                            @elseif($item->status == 'menunggu_pembayaran') bg-warning
                            @elseif($item->status == 'dalam_proses') bg-primary
                            @elseif($item->status == 'selesai') bg-success
                            @elseif($item->status == 'dibatalkan') bg-light text-dark
                            @else bg-danger
                            @endif">
                            {{ ucfirst(str_replace('_',' ', $item->status)) }}
                        </span>
                    </div>

                </div>
                    @if ($item->status == 'diterima' || $item->status == 'menunggu_pembayaran')
                        <div class="d-flex">
                            <div class="">
                                <a href="" class="btn btn-lg btn-outline-primary mt-2 me-2" data-bs-toggle="modal"
                                    data-bs-target="#hubungiJasa">Hubungi Customer</a>
                            </div>
                            <div class="">
                                <a href="/user/list-order/invoice/{{$item->id}}" class="btn btn-lg btn-primary mt-2">Buat Invoice</a>
                            </div>
                        </div>
                    @endif
                    @if ($item->status == 'selesai')
                        <div class="">
                            <a href="/user/list-order/invoice/{{$item->id}}" class="btn btn-lg btn-primary mt-2">Lihat Detail</a>
                        </div>
                    @endif

                    <div class="modal fade" id="hubungiJasa" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="{{ route('user.order.jasa') }}" method="POST">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title">Hubungi Customer</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="alert alert-info w-100">
                                            Chat memlalui Whatsapp dengan customer
                                        </div>
                                        <small>No WhatsApp</small>
                                        <h4><b>{{$item->user->no_hp}}</b></h4>
                                        @php
                                            $noWa = '62' . ltrim($item->user->no_hp, '0');
                                        @endphp

                                        <a href="https://wa.me/{{ $noWa }}?text=Halo%20saya%20{{ Auth::user()->nama }}%20apakah%20anda%20ingin%20memesan%20jasa%20{{ $item->job->title }}"
                                        target="_blank"
                                        class="btn btn-success btn-lg mt-2 d-inline-flex align-items-center gap-2">
                                            <i class="fab fa-whatsapp"></i>
                                            Chat Customer
                                        </a>


                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                @if ($item->status == 'pending')
                <div class="d-flex">
                    <form action="{{ url('/user/transaksi/ditolak/' . $item->id) }}" 
                        method="POST"
                        onsubmit="return confirm('Apakah anda yakin ingin tolak pesanan ini?')">
                        
                        @csrf
                        
                        <button type="submit" class="mt-2 btn btn-outline-danger me-2">
                            Tolak
                        </button>
                    </form>
                    <form action="{{ url('/user/transaksi/diterima/' . $item->id) }}" 
                        method="POST"
                        onsubmit="return confirm('Apakah anda yakin ingin terima pesanan ini?')">
                        
                        @csrf
                        
                        <button type="submit" class="mt-2 btn btn-success">
                            Terima
                        </button>
                    </form>
                </div>
                @endif
              
            </div>
        </div>
        @endif
    @empty
        <div class="text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="120" class="mb-3">
            <h6 class="text-muted">Belum ada transaksi</h6>
        </div>
    @endforelse

</div>
@endsection
