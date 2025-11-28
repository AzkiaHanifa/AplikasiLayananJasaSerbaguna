<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* CSS Tambahan jika perlu */
        body {
            background-color: #f8f9fa; /* Abu-abu muda agar tidak terlalu silau */
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Nama Website Anda
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        {{-- Jika belum login --}}
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                            </li>
                        @endif
                    @else
                        {{-- Jika SUDAH login --}}
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" roles="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name ?? Auth::user()->email }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                
                                {{-- Link Dashboard berdasarkan Roles --}}
                                @if(Auth::user()->roles == 'admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                                @elseif(Auth::user()->roles == 'mitra')
                                    <a class="dropdown-item" href="{{ route('mitra.home') }}">Dashboard Mitra</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('user.home') }}">Home User</a>
                                    <a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a>
                                @endif

                                <hr class="dropdown-divider">

                                {{-- Tombol Logout --}}
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        {{-- Ini adalah 'Lubang' tempat konten dari @section('content') akan masuk --}}
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>