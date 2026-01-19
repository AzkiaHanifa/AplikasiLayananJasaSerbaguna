@extends('layouts.user.main')

@section('content')
<br><br><br><br><br><br>

<div class="container py-5">

    {{-- HEADER TRANSAKSI --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-1">Detail Transaksi Jasa</h5>
            <b class="text-primary">{{$transaksi->job->title}}</b><br>
            <small class="text-muted">
                Kode Transaksi: {{ $transaksi->kode_transaksi }}
            </small>

            <hr>

            <p class="mb-1"><strong>Status:</strong>
                <span class="badge bg-info">
                    {{ strtoupper(str_replace('_', ' ', $transaksi->status)) }}
                </span>
            </p>

            <p class="mb-1"><strong>Catatan:</strong></p>
            <p class="text-muted">
                {{ $transaksi->alamat_tujuan ?? '-' }}
            </p>
        </div>
    </div>

    {{-- DAFTAR INVOICE --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Daftar Invoice</h5>

            @if($transaksi->invoices->count())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No Invoice</th>
                                {{-- <th>Tipe</th> --}}
                                <th>Total</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    {{-- <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($invoice->tipe_invoice) }}
                                        </span>
                                    </td> --}}
                                    <td>
                                        Rp {{ number_format($invoice->total, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @if($invoice->status == 'dibayar')
                                            <span class="badge bg-success">Dibayar</span>
                                        @elseif($invoice->status == 'menunggu_pembayaran')
                                            <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $invoice->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="/user/list-order/invoice/{{$transaksi->id}}/detail/{{$invoice->id }}"
                                        class="btn btn-sm btn-outline-primary">
                                            Detail
                                        </a>

                                        @if($invoice->bukti_pembayaran)
                                            <button
                                                class="btn btn-sm btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#buktiModal"
                                                onclick="showBukti('{{ asset('storage/'.$invoice->bukti_pembayaran) }}')">
                                                Lihat Bukti
                                            </button>
                                        @endif

                                        {{-- @if($invoice->status == 'menunggu_pembayaran')
                                            <form action="{{ url('/invoice/'.$invoice->id.'/bayar') }}"
                                                method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success"
                                                        onclick="return confirm('Konfirmasi pembayaran?')">
                                                    Konfirmasi Bayar
                                                </button>
                                            </form>
                                        @endif --}}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Belum ada invoice.</p>
            @endif
        </div>
    </div>

    @if ($transaksi->status != 'selesai')
        
    {{-- AKSI UTAMA --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Aksi</h5>
            
            <div class="d-flex " style="justify-content: space-between">
                
                {{-- BUAT INVOICE --}}
                @if($transaksi->status != 'selesai')
                <a href="{{ url('/user/list-order/invoice/'.$transaksi->id.'/create') }}"
                    class="btn btn-primary">
                    Buat Invoice
                </a>
                @endif
                <div>
                    
                    
                    <form action="{{ url('/user/list-order/invoice/'.$transaksi->id.'/proses') }}"
                        method="POST"
                        class="d-inline">
                        @csrf
                        <button class="btn btn-warning" {{$transaksi->status == 'dalam_proses' ? 'disabled' : ''}}
                            onclick="return confirm('Proses transaksi ini?')">
                            Proses Pesanan
                        </button>
                    </form>
                    <form action="{{ url('/user/list-order/invoice/'.$transaksi->id.'/selesai') }}"
                        method="POST"
                        class="d-inline">
                        @csrf
                        <button class="btn btn-success"
                        onclick="return confirm('Selesaikan transaksi ini?')">
                        Tandai Selesai
                    </button>
                </form>
            </div>
        </div> 
    </div>
</div>
@endif

</div>

<!-- Modal Preview Bukti Pembayaran -->
<div class="modal fade" id="buktiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img id="buktiImage"
                     src=""
                     class="img-fluid rounded"
                     alt="Bukti Pembayaran">
                     <br><br>
                     @if($invoice->status == 'dibayar')
                        <form action="/user/list-order/invoice/{{ $transaksi->id }}/bayar"
                            method="POST"
                            class="d-inline">
                            @csrf
                            <input type="hidden" name="id_invoice" value="{{$invoice->id}}">
                            <button class="btn btn-success"
                                    onclick="return confirm('Konfirmasi pembayaran invoice ini?')">
                                Konfirmasi Pembayaran
                            </button>
                        </form>
                    @endif
            </div>
        </div>
    </div>
</div>
<script>
    function showBukti(src) {
        document.getElementById('buktiImage').src = src;
    }
</script>

@endsection
