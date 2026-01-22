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

                                        @if($invoice->status == 'menunggu_pembayaran')
                                            <button
                                                class="btn btn-sm btn-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#uploadBuktiModal"
                                                onclick="setInvoiceId({{ $invoice->id }})">
                                                Upload Bukti Bayar
                                            </button>
                                        @endif

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
    @if ($transaksi->status == 'selesai')
        {{-- AKSI UTAMA --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Ulasan Anda</h5>

                    @if($transaksi->ulasan)
                        {{-- Rating --}}
                        @php $rating = $transaksi->ulasan->rating ?? 0; @endphp

                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $rating ? 'fa fa-star text-warning' : 'fa fa-star star-empty' }}"></i>
                            @endfor
                        </div>

                        {{-- Text --}}
                        @if($transaksi->ulasan->ulasan)
                            <p class="mb-1">
                                "{{ $transaksi->ulasan->ulasan }}"
                            </p>
                        @else
                            <p class="text-muted fst-italic">
                                Tidak ada komentar.
                            </p>
                        @endif

                        <small class="text-muted">
                            Diberikan pada {{ $transaksi->ulasan->created_at->format('d M Y') }}
                        </small>
                    @else
                        <p class="text-muted mb-3">
                            Anda belum memberikan ulasan untuk transaksi ini.
                        </p>

                        {{-- Tombol buka modal --}}
                        <button class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#ulasanModal"
                                onclick="setTransaksi({{ $transaksi->id }})">
                            <i class="fa fa-star me-1"></i> Berikan Penilaian
                        </button>
                    @endif
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
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Bukti Pembayaran -->
<div class="modal fade" id="uploadBuktiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form
            method="POST"
            action="{{ url('/user/transaksi/invoice/upload-bukti') }}"
            enctype="multipart/form-data"
            class="modal-content">

            @csrf

            <input type="hidden" name="invoice_id" id="invoice_id">

            <div class="modal-header">
                <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Bukti Pembayaran (Gambar)</label>
                    <input type="file"
                           name="bukti_pembayaran"
                           class="form-control"
                           accept="image/*"
                           required>
                </div>

                <small class="text-muted">
                    Format JPG / PNG, max 2MB
                </small>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    Upload
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ulasan -->
<div class="modal fade" id="ulasanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="/user/transaksi/ulasan" class="modal-content">
            @csrf

            <input type="hidden" name="transaksi_id" id="transaksi_id">
            <input type="hidden" name="rating" id="rating">

            <div class="modal-header">
                <h5 class="modal-title">Beri Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                {{-- Bintang --}}
                <div class="mb-3">
                    <i class="fa fa-star fa-2x star" data-value="1"></i>
                    <i class="fa fa-star fa-2x star" data-value="2"></i>
                    <i class="fa fa-star fa-2x star" data-value="3"></i>
                    <i class="fa fa-star fa-2x star" data-value="4"></i>
                    <i class="fa fa-star fa-2x star" data-value="5"></i>
                </div>

                {{-- Text --}}
                <textarea name="ulasan"
                          class="form-control"
                          rows="3"
                          placeholder="Tulis ulasan (opsional)"></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">
                    Kirim Penilaian
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .star {
        cursor: pointer;
        color: #ccc;
    }
    .star.active {
        color: #f5b301;
    }
    .star-empty {
        color: #d1d5db;
    }
</style>

<script>
    function setTransaksi(id) {
        document.getElementById('transaksi_id').value = id;
    }

    const stars = document.querySelectorAll('.star');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            let rating = this.dataset.value;
            document.getElementById('rating').value = rating;

            stars.forEach(s => s.classList.remove('active'));
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add('active');
            }
        });
    });
</script>


<script>
    function showBukti(src) {
        document.getElementById('buktiImage').src = src;
    }
    function setInvoiceId(id) {
        document.getElementById('invoice_id').value = id;
    }
</script>

@endsection
