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
            <h3 class="mb-4 text-start">Login</h3>
            <div class="text-start mb-3">Silahkan masuk di LPJS</div>

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                {{-- Email / Nama --}}
                <div class="mb-2">
                    <input 
                        type="text" 
                        name="nama" 
                        class="form-control" 
                        placeholder="Email" 
                        required autofocus
                    >
                </div>

                {{-- Password + Show/Hide --}}
                <div class="mb-2 password-wrapper">
                    <input 
                        type="password" 
                        name="password" 
                        id="login_password"
                        class="form-control" 
                        placeholder="Password" 
                        required
                    >
                    <span class="toggle-password" onclick="togglePassword('login_password', this)">
                        👁️
                    </span>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger py-2 text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit" class="btn btn-primary btn-lg w-100 btn-login mt-2">
                    Login
                </button>
            </form>

            <button onclick="location.href='register'" 
                class="btn btn-lg btn-outline-primary w-100 mt-2 register-btn">
                Daftar
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
