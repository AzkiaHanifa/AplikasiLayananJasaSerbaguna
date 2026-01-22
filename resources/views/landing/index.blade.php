@extends('layouts.user.main')

@section('content')

    {{-- CSS MINIMALIS (Hanya untuk bentuk lingkaran, TANPA EFEK WARNA SAAT KLIK) --}}
    <style>
        /* Reset background default Bootstrap agar tidak ada kotak biru saat diklik */
        .nav-pills .nav-link.active, 
        .nav-pills .show > .nav-link {
            background-color: transparent !important;
            color: #333 !important;
        }
        
        /* Style dasar lingkaran kategori */
        .cat-circle {
            width: 75px; 
            height: 75px;
            background-color: #fff;
            border: 1px solid #dee2e6; /* Border abu tipis */
            border-radius: 50%;
            display: flex; 
            align-items: center; 
            justify-content: center;
            overflow: hidden;
            margin: 0 auto 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        /* Agar gambar pas di tengah */
        .cat-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            padding: 0;
        }
        .menu-scroll {
        display: flex;
        gap: 40px;
        overflow-x: auto;
        padding-bottom: 10px;
        scrollbar-width: none; /* Firefox */
        }

        .menu-scroll::-webkit-scrollbar {
        display: none; /* Chrome */
        }

        .menu-item {
        flex: 0 0 auto;
        text-align: center;
        width: 90px;
        }

        .icon-circle {
        width: 90px;
        height: 90px;
        background-color: #2f93d1;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin: 0 auto 8px;
        }

        .menu-item span {
        font-size: 14px;
        font-weight: 500;
        color: black;
        }
    </style>

    {{-- MODAL SEARCH --}}
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- HERO BANNER --}}
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-1">
            <div class="row g-5 align-items-center">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        @forelse($banners as $key => $banner)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }} rounded">
                                <img src="{{ asset('storage/' . $banner->image) }}" class="w-100 bg-secondary rounded" alt="{{ $banner->title ?? 'Banner Image' }}" style="height: 100%;">
                                @if($banner->title)
                                {{-- <div class="carousel-caption d-none d-md-block">
                                    <h3 class="text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">{{ $banner->title }}</h3>
                                </div> --}}
                                @endif
                            </div>
                        @empty
                            <div class="carousel-item active rounded">
                                <img src="{{ asset('assets/user/img/hero-img-1.png') }}" class="w-100 bg-secondary rounded" alt="Default Banner" style="height: 400px; object-fit: cover;">
                            </div>
                        @endforelse
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="menu-scroll">
            <a href="/kategori">
                <div class="menu-item">
                    <div class="icon-circle"><i class="fas fa-th-large text-white fs-3"></i></div>
                    <span>Semua</span>
                </div>
            </a>
            @php
                use App\Models\Category;
                $kategori = Category::all()->where('is_featured', 1);
            @endphp
            @foreach ($kategori as $item)
                <a href="{{ route('kategori.show', $item->slug) }}">
                    <div class="menu-item">
                        <div class="icon-circle">
                            <img src="{{ asset('storage/' . $item->icon) }}" alt="{{ $item->name }}">
                        </div>
                        <span>{{ $item->name }}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </div>

    {{-- FEATURES --}}
    <div class="container-fluid featurs py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto"><i class="fas fa-car-side fa-3x text-white"></i></div>
                        <div class="featurs-content text-center"><h5>Cepat & Tepat</h5><p class="mb-0">Layanan jasa profesional</p></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto"><i class="fas fa-user-shield fa-3x text-white"></i></div>
                        <div class="featurs-content text-center"><h5>Keamanan Terjamin</h5><p class="mb-0">Verifikasi Mitra Ketat</p></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto"><i class="fas fa-exchange-alt fa-3x text-white"></i></div>
                        <div class="featurs-content text-center"><h5>Garansi Layanan</h5><p class="mb-0">Kepuasan pelanggan utama</p></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto"><i class="fa fa-phone-alt fa-3x text-white"></i></div>
                        <div class="featurs-content text-center"><h5>24/7 Support</h5><p class="mb-0">Siap membantu kapanpun</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid fruite">
        <div class="container py-5">
            <div class="tab-class">

                {{-- JUDUL --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h3>Jasa Untuk Kamu</h3>
                    </div>
                </div>

                {{-- GRID CARD --}}
                <div class="row g-4">
                    @foreach($jobs as $job)
                        @php
                            $rating = round($job->avg_rating ?? 0, 1);
                            $fullStar = floor($rating);
                            $halfStar = ($rating - $fullStar) >= 0.5;
                            $emptyStar = 5 - $fullStar - ($halfStar ? 1 : 0);
                        @endphp

                        <!--
                        col-6   → mobile = 2 kolom
                        col-md-4 → tablet = 3 kolom
                        col-lg-3 → desktop = 4 kolom
                        -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <div style="border-radius: 15px;"
                                class="position-relative fruite-item border h-100 d-flex flex-column">

                                <div class="fruite-img" style="height: 200px; overflow: hidden;">
                                    <a href="{{ route('job.show', $job->id) }}">
                                        @if($job->job_image)
                                            <img src="{{ asset('storage/' . $job->job_image) }}"
                                                class="img-fluid w-100 rounded-top"
                                                alt="{{ $job->title }}"
                                                style="height: 100%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/user/img/fruite-item-5.jpg') }}"
                                                class="img-fluid w-100 rounded-top"
                                                alt="default"
                                                style="height: 100%; object-fit: cover;">
                                        @endif
                                    </a>
                                </div>

                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                    style="top: 10px; left: 10px;">
                                    {{ $job->category->name }}
                                </div>

                                <div class="p-4 border-top-0 rounded-bottom d-flex flex-column flex-grow-1 text-start">
                                    <h5>{{ Str::limit($job->title, 35) }}</h5>
                                    <p class="small">{{ Str::limit($job->description, 50) }}</p>

                                    {{-- Rating --}}
                                    <div class="mb-3 d-flex align-items-center gap-1">
                                        @for($i = 1; $i <= $fullStar; $i++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor

                                        @if($halfStar)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @endif

                                        @for($i = 1; $i <= $emptyStar; $i++)
                                            <i class="far fa-star text-warning"></i>
                                        @endfor

                                        <small class="text-muted ms-1">
                                            {{ number_format($rating, 1) }}
                                        </small>
                                    </div>

                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <p class="text-dark fw-bold mb-0 small">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            {{ Str::limit($job->location, 13) }}
                                        </p>

                                        <a href="{{ route('job.show', $job->id) }}"
                                        class="btn btn-sm border border-primary rounded-pill px-3 text-primary">
                                            Order
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $jobs->links() }}
                </div>

            </div>
        </div>

    </div>

    {{-- CAROUSEL JASA TERBARU --}}
    {{-- <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h3 class="mb-0">Jasa Untuk Kamu</h3>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                @foreach($jobs->take(6) as $job) 
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <a href="{{ route('job.show', $job->id) }}">
                            @if($job->job_image)
                                <img src="{{ asset('storage/' . $job->job_image) }}" class="img-fluid w-100 rounded-top" alt="" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/user/img/vegetable-item-6.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="height: 200px; object-fit: cover;">
                            @endif
                        </a>
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">New</div>
                    <div class="p-4 rounded-bottom">
                        <h4>{{ $job->title }}</h4>
                        <p>{{ Str::limit($job->description, 40) }}</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">{{ $job->location }}</p>
                            @auth
                                <a href="{{ route('job.show', $job->id) }}" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i></a>
                            @else
                                <a href="{{ route('login') }}" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-lock me-2 text-primary"></i></a>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    {{-- BANNER MITRA --}}
    <div class="container-fluid banner bg-secondary my-5">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="py-4">
                        <h1 class="display-3 text-white">Bergabung Jadi Mitra/Jasa</h1>
                        <p class="fw-normal display-3 text-white mb-4">Dapatkan Penghasilan</p>
                        <p class="mb-4 text-white">Tawarkan keahlian Anda kepada ribuan pengguna aktif kami setiap harinya.</p>
                        <a href="{{ route('register') }}" class="banner-btn btn border-2 border-white rounded-pill text-white py-3 px-5">DAFTAR SEKARANG</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="{{ asset('images/kuli.png') }}" class="img-fluid w-100 rounded" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection