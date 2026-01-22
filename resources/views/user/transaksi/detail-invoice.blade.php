@extends('layouts.user.main')

@section('content')
<br><br><br><br><br><br>

<div class="container py-5">

    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-1">Detail Invoice</h4>
            <small class="text-muted">
                {{ $invoice->invoice_number }}
            </small>
        </div>
    </div>

    {{-- INFO INVOICE --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6>Informasi Invoice</h6>
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>Status</td>
                            <td>:</td>
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
                        </tr>
                        {{-- <tr>
                            <td>Tipe Invoice</td>
                            <td>:</td>
                            <td>{{ ucfirst($invoice->tipe_invoice) }}</td>
                        </tr> --}}
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ $invoice->created_at->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td>{{ $invoice->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6>Informasi Transaksi</h6>
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>Kode Transaksi</td>
                            <td>:</td>
                            <td>{{ $invoice->transaksi->kode_transaksi }}</td>
                        </tr>
                        <tr>
                            <td>Nama Jasa</td>
                            <td>:</td>
                            <td>{{ $invoice->transaksi->job->title }}</td>
                        </tr>
                        <tr>
                            <td>Status Transaksi</td>
                            <td>:</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ strtoupper(str_replace('_',' ',$invoice->transaksi->status)) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ITEM INVOICE --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Rincian Pekerjaan</h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Deskripsi</th>
                            <th width="100">Qty</th>
                            <th width="150">Harga</th>
                            <th width="150">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format($item->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">Subtotal</th>
                            <th>
                                Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}
                            </th>
                        </tr>
                        @if($invoice->diskon > 0)
                        <tr>
                            <th colspan="3" class="text-end">Diskon</th>
                            <th>
                                - Rp {{ number_format($invoice->diskon, 0, ',', '.') }}
                            </th>
                        </tr>
                        @endif
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>
                                Rp {{ number_format($invoice->total, 0, ',', '.') }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- AKSI --}}
    <div class="card shadow-sm">
        <div class="card-body text-end">

            @if($invoice->status == 'menunggu_pembayaran')
                <form action="/user/list-order/invoice/{{ $invoice->id }}/bayar"
                      method="POST"
                      class="d-inline">
                    @csrf
                    <button class="btn btn-success"
                            onclick="return confirm('Konfirmasi pembayaran invoice ini?')">
                        Konfirmasi Pembayaran
                    </button>
                </form>
            @endif

        </div>
    </div>

</div>
@endsection
