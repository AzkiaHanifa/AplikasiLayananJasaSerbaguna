@extends('layouts.user.main')

@section('content')
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
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-1">
            <div class="row g-5 align-items-center">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active rounded">
                            <img src="{{ asset('assets/user/img/hero-img-1.png') }}" style="height: 400px; object-fit: cover;" class=" w-100 bg-secondary rounded" alt="First slide">
                        </div>
                        <div class="carousel-item rounded">
                            <img src="{{ asset('assets/user/img/hero-img-2.jpg') }}" style="height: 400px; object-fit: cover;" class=" w-100 rounded" alt="Second slide">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid featurs py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-car-side fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Cepat & Tepat</h5>
                            <p class="mb-0">Layanan jasa profesional</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-user-shield fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Keamanan Terjamin</h5>
                            <p class="mb-0">Verifikasi Mitra Ketat</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-exchange-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Garansi Layanan</h5>
                            <p class="mb-0">Kepuasan pelanggan utama</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fa fa-phone-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>24/7 Support</h5>
                            <p class="mb-0">Siap membantu kapanpun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Jasa Tersedia</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-all">
                                    <span class="text-dark" style="width: 130px;">Semua</span>
                                </a>
                            </li>
                            
                            @foreach($categories as $category)
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-{{ $category->id }}">
                                    <span class="text-dark" style="width: 130px;">{{ $category->name }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    
                    <div id="tab-all" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach($jobs as $job)
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <a href="{{ route('job.show', $job->id) }}">
                                                    @if($job->job_image)
                                                        <img src="{{ asset('storage/' . $job->job_image) }}" class="img-fluid w-100 rounded-top" alt="{{ $job->title }}" style="height: 200px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('assets/user/img/fruite-item-5.jpg') }}" class="img-fluid w-100 rounded-top" alt="default" style="height: 200px; object-fit: cover;">
                                                    @endif
                                                </a>
                                            </div>
                                            
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                                {{ $job->category->name }}
                                            </div>
                                            
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ $job->title }}</h4>
                                                <p>{{ Str::limit($job->description, 50) }}</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">{{ $job->location }}</p>
                                                    
                                                    @auth
                                                        <a href="{{ route('job.show', $job->id) }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Order
                                                        </a>
                                                    @else
                                                        <a href="{{ route('login') }}" onclick="return confirm('Silahkan login terlebih dahulu untuk memesan jasa ini.')" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                            <i class="fa fa-lock me-2 text-primary"></i> Login
                                                        </a>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @foreach($categories as $category)
                    <div id="tab-{{ $category->id }}" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @php
                                        // Filter collection jobs agar sesuai kategori tab saat ini
                                        $filteredJobs = $jobs->where('category_id', $category->id);
                                    @endphp

                                    @if($filteredJobs->count() > 0)
                                        @foreach($filteredJobs as $job)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <a href="{{ route('job.show', $job->id) }}">
                                                        @if($job->job_image)
                                                            <img src="{{ asset('storage/' . $job->job_image) }}" class="img-fluid w-100 rounded-top" alt="{{ $job->title }}" style="height: 200px; object-fit: cover;">
                                                        @else
                                                            <img src="{{ asset('assets/user/img/fruite-item-5.jpg') }}" class="img-fluid w-100 rounded-top" alt="default" style="height: 200px; object-fit: cover;">
                                                        @endif
                                                    </a>
                                                </div>

                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                                    {{ $job->category->name }}
                                                </div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>{{ $job->title }}</h4>
                                                    <p>{{ Str::limit($job->description, 50) }}</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">{{ $job->location }}</p>
                                                        @auth
                                                            <a href="{{ route('job.show', $job->id) }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Order
                                                            </a>
                                                        @else
                                                            <a href="{{ route('login') }}" onclick="return confirm('Silahkan login terlebih dahulu untuk memesan jasa ini.')" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                <i class="fa fa-lock me-2 text-primary"></i> Login
                                                            </a>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center py-5">
                                            <p class="text-muted">Belum ada jasa di kategori ini.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>      
        </div>
    </div>
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-0">Jasa Terbaru</h1>
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
    </div>
    <div class="container-fluid banner bg-secondary my-5">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="py-4">
                        <h1 class="display-3 text-white">Bergabung Jadi Mitra</h1>
                        <p class="fw-normal display-3 text-dark mb-4">Dapatkan Penghasilan</p>
                        <p class="mb-4 text-dark">Tawarkan keahlian Anda kepada ribuan pengguna aktif kami setiap harinya.</p>
                        <a href="{{ route('register') }}" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">DAFTAR SEKARANG</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="{{ asset('assets/user/img/baner-1.png') }}" class="img-fluid w-100 rounded" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection