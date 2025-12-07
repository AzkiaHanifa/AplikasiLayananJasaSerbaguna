@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            {{-- Kartu Sambutan --}}
            <div class="card shadow-sm border-0">
                <div class="card-body p-5 text-center">
                    
                    <h1 class="display-6 fw-bold text-primary mb-3">
                        Halo, {{ Auth::user()->nama ?? 'User' }}! 👋
                    </h1>
                    
                    <p class="lead text-muted mb-4">
                        Selamat datang di Dashboard User.
                    </p>

                    <hr class="w-50 mx-auto mb-4">

                    {{-- Area Tombol --}}
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        
                        {{-- 1. Tombol Profil (Opsional, jika ingin tetap ada) --}}
                      

                        {{-- 2. Tombol Logout --}}
                        <a href="{{ route('logout') }}" 
                           class="btn btn-danger px-4"
                           onclick="event.preventDefault(); document.getElementById('logout-form-dashboard').submit();">
                            Logout
                        </a>

                        {{-- Form Hidden (Wajib ada untuk proses Logout Laravel) --}}
                        <form id="logout-form-dashboard" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection