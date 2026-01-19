@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <br><br>
    <h1 class="mb-4">Selamat Datang di Dashboard Admin</h1>

    <div class="row ">
        <div class="col-md-4">
            <div class="card border border-light shadow-sm bg-white text-dark h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.8rem;">Total Pekerjaan</h6>
                        <h2 class="mb-0 fw-bold text-primary">{{ $totalJobs }}</h2>
                    </div>
                    <div class="fs-1 text-gray-300">
                        <i class="fas fa-briefcase text-muted opacity-25"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top border-light small">
                    <a href="{{ route('admin.jobs.index') }}" class="text-primary text-decoration-none fw-bold">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border border-light shadow-sm bg-white text-dark h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.8rem;">Total Kategori</h6>
                        <h2 class="mb-0 fw-bold text-success">{{ $totalCategories }}</h2>
                    </div>
                    <div class="fs-1 text-gray-300">
                        <i class="fas fa-tags text-muted opacity-25"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top border-light small">
                    <a href="{{ route('admin.categories.index') }}" class="text-success text-decoration-none fw-bold">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border border-light shadow-sm bg-white text-dark h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.8rem;">Total Transaksi</h6>
                        <h2 class="mb-0 fw-bold text-danger">{{ $totalTransaksi }}</h2>
                    </div>
                    <div class="fs-1 text-gray-300">
                        <i class="fas fa-receipt text-muted opacity-25"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top border-light small">
                    <a href="{{ route('admin.transaksi.index') }}" class="text-danger text-decoration-none fw-bold">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <br>
            <div class="card border border-light shadow-sm bg-white text-dark h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.8rem;">Pengguna Terdaftar</h6>
                        <h2 class="mb-0 fw-bold text-warning">{{ $totalUsers }}</h2>
                    </div>
                    <div class="fs-1 text-gray-300">
                        <i class="fas fa-users text-muted opacity-25"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top border-light small">
                    <a href="{{ route('admin.users.index') }}" class="text-warning text-decoration-none fw-bold">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <hr class="my-5">

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white py-3">
             <h6 class="m-0 font-weight-bold text-primary">Menu Utama Job Management</h6>
        </div>
        <div class="card-body">
             
             <a href="{{ route('admin.banners.index') }}" class="btn btn-primary">Edit Banner</a>
           
        </div>
    </div>

    
    <br><br>
</div>
@endsection