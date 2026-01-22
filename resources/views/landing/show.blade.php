@extends('layouts.user.main')

@section('content')

<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Detail Jasa</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home.landing') }}">Home</a></li>
        <li class="breadcrumb-item active text-white">Detail</li>
    </ol>
</div>

<div class="container-fluid py-5 ">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="border rounded">
                            <a href="#">
                                @if($job->job_image)
                                    <img src="{{ asset('storage/' . $job->job_image) }}" class="img-fluid rounded w-100" alt="Image">
                                @else
                                    <img src="{{ asset('assets/user/img/fruite-item-5.jpg') }}" class="img-fluid rounded w-100" alt="Image">
                                @endif
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <span class="badge mb-2 rounded-pill 
                            @if($job->is_job == 'tersedia') bg-success
                            @else bg-danger
                            @endif">
                            {{ ucfirst(str_replace('_',' ', $job->is_job)) }}
                        </span>  
                        <h4 class="fw-bold mb-3">{{ $job->title }}</h4>
                        
                        <p class="mb-3">Kategori: <span class="badge bg-secondary">{{ $job->category->name }}</span></p>
                        
                        <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill"></i> Lokasi: {{ $job->location }}</h5>
                        
                        <p class="mb-4">{{ $job->description }}</p>

                        <div class="input-group quantity " style="width: 100px;">
                            </div>

                        @auth
                            <a href="#" 
                                class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#orderJasaModal">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Order Jasa Ini
                            </a>
                        @else
                            <a href="{{ route('login') }}" onclick="return confirm('Silahkan login terlebih dahulu.')" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                <i class="fa fa-lock me-2 text-primary"></i> Login to Order
                            </a>
                        @endauth
                    </div>
                    
                    <div class="col-lg-12">
                        <nav>
                            <div class="nav nav-tabs mb-3">
                                <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                    id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                    aria-controls="nav-about" aria-selected="true">Description</button>
                                <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                    id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                    aria-controls="nav-mission" aria-selected="false">Mitra Info</button>
                            </div>
                        </nav>
                        <div class="tab-content mb-5">
                            <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                <p>{{ $job->description }}</p>
                            </div>
                            <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                <div class="d-flex">
                                    <div class="">
                                        <p class="mb-2" style="font-size: 14px;">Nama Mitra:</p>
                                        <h6>{{ $job->user->nama ?? 'Mitra Terdaftar' }}</h6>
                                        <p class="mb-2" style="font-size: 14px;">Kontak:</p>
                                        <h6>{{ $job->user->no_hp ?? '-' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="p-4">
                                <h5 class="mb-3">Rating & Ulasan Jasa</h5>

                                <div class="d-flex align-items-center gap-4">
                                    {{-- Angka Rating --}}
                                    <div class="display-4 fw-bold" style="color: black;">
                                        {{ number_format($avgRating, 1) }}
                                    </div>

                                    {{-- Bintang --}}
                                    @php
                                        $full = floor($avgRating);
                                        $half = ($avgRating - $full) >= 0.5;
                                        $empty = 5 - $full - ($half ? 1 : 0);
                                    @endphp

                                    <div>
                                        @for($i=1;$i<=$full;$i++)
                                            <i class="fas fa-star text-warning fs-4"></i>
                                        @endfor

                                        @if($half)
                                            <i class="fas fa-star-half-alt text-warning fs-4"></i>
                                        @endif

                                        @for($i=1;$i<=$empty;$i++)
                                            <i class="far fa-star text-warning fs-4"></i>
                                        @endfor

                                        <div class="text-muted mt-2">
                                            Berdasarkan <strong>{{ $totalUlasan }}</strong> ulasan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="">
                                @forelse($ulasan as $u)
                                    <div class="border-bottom pb-3 mb-3">
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            {{-- Avatar --}}
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                style="width:35px;height:35px;">
                                                <strong class="text-white">{{ strtoupper(substr($u->transaksi->user->nama,0,1)) }}</strong>
                                            </div>

                                            <strong style="color: black;">{{ $u->transaksi->user->nama }}</strong>
                                        </div>

                                        {{-- Bintang --}}
                                        <div class="mb-2">
                                            @for($i=1;$i<=5;$i++)
                                                @if($i <= $u->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>

                                        {{-- Ulasan --}}
                                        <p class="mb-1">
                                            {{ $u->ulasan }}
                                        </p>

                                        {{-- Tanggal --}}
                                        <small class="text-muted">
                                            {{ $u->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">Belum ada ulasan untuk jasa ini.</p>
                                @endforelse
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-xl-3">
                <div class="row g-4 fruite">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <h4>Kategori</h4>
                            <ul class="list-unstyled fruite-categorie">
                                <li>
                                    <div class="d-flex justify-content-between fruite-name">
                                        <a href="{{ route('home.landing') }}"><i class="fas fa-apple-alt me-2"></i>Kembali ke Semua Jasa</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderJasaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('user.order.jasa') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Order Jasa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- JOB ID --}}
                    <input type="hidden" name="job_id" value="{{ $job->id }}">

                    {{-- ALAMAT TUJUAN --}}
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="alamat_tujuan" class="form-control" rows="3" ></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Order Sekarang
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection