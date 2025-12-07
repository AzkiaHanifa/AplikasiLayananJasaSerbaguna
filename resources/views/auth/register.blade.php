@extends('layouts.user.main')

@section('content')
    <style>
        .login-card {
            margin-top: 250px;
            margin-bottom: 250px;
            width: 100%;
            max-width: 400px;
            border-radius: 20px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
    </style>

<div class="container">
    <center>
        <div class="login-card">
            <h3 class="mb-4 text-start">Registrasi</h3>
            <div class="text-start mb-3">Silahkan daftar akun baru di LPJS</div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 text-start">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/register" method="POST">
                @csrf

                <div class="mb-2">
                    <input 
                        type="text" 
                        name="email" 
                        class="form-control" 
                        placeholder="Email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                {{-- Password --}}
                <div class="mb-2 password-wrapper">
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        class="form-control" 
                        placeholder="Password" 
                        required
                    >
                    <span class="toggle-password" onclick="togglePassword('password', this)">
                        👁️
                    </span>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-3 password-wrapper">
                    <input 
                        type="password" 
                        id="password_confirmation"
                        name="password_confirmation" 
                        class="form-control" 
                        placeholder="Konfirmasi Password" 
                        required
                    >
                    <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                        👁️
                    </span>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 mt-2">
                    Daftar
                </button>
            </form>

            <button onclick="location.href='{{ url('/login') }}'" 
                class="btn btn-lg btn-outline-primary w-100 mt-2">
                Login
            </button>
        </div>
    </center>
</div>

<script>
    function togglePassword(fieldId, iconElement) {
        const field = document.getElementById(fieldId);
        const isPassword = field.type === "password";

        field.type = isPassword ? "text" : "password";
        iconElement.textContent = isPassword ? "🙈" : "👁️";
    }
</script>

@endsection
