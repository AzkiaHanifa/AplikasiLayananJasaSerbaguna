<!-- Navbar start -->
<div class="container-fluid fixed-top border">
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-phone me-2 text-secondary"></i> <a href="#" class="text-white">CS. 083180112238</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">info@lpsjs.com</a></small>
            </div>
            <div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2">Cara memesan Jasa?</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-2">Cara daftar Jasa?</small></a>
            </div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="/" class="navbar-brand d-flex mt-2"><img src="{{asset('images/logo-lpjs.png')}}" class="me-3" style="width: 40px; height: 40px;" alt=""><h1 class="text-primary display-6">LPJS</h1></a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="search-wrapper d-flex gap-2 col-sm-6">
                    <div class="search-box">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control search-input shadow-sm" placeholder="Cari jasa yang Anda butuhkan...">
                    </div>
                    <button class="btn btn-primary btn-search shadow-sm text-white">
                        Cari Jasa
                    </button>
                </div>
                {{-- <div class="navbar-nav mx-auto">
                    <a href="contact.html" class="nav-item nav-link">Contact</a>
                </div> --}}
                @if (auth()->check())
                    <div class="d-flex m-3 me-0">
                        <a href="#" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                        </a>
                        <a href="#" class="my-auto">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                    </div>
                @else
                    <div class="d-flex m-3 me-0">
                        <a href="/register" class="btn btn-outline-primary btn-lg me-2">
                            Daftar
                        </a>
                        <a href="/login" class="btn btn-primary btn-lg">
                            Login
                        </a>
                    </div>
                @endif
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->

<style>
    .search-wrapper {
        max-width: 600px;
        margin: auto;
    }

    .search-box {
        position: relative;
        flex: 1;
    }

    .search-input {
        border-radius: 15px;
        padding-left: 48px;
        height: 48px;
        background: #f8f9fa;
        transition: all .3s ease;
    }

    .search-input:focus {
        background: #fff;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 18px;
    }

    .btn-search {
        border-radius: 15px;
        padding: 0 28px;
        height: 48px;
    }
</style>