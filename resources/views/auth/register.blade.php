<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
</head>
<body>
    <h2>Form Registrasi Akun Baru</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf

        <label>Alamat Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Konfirmasi Password:</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Daftar Sekarang</button>
    </form>
    
    <p>Sudah punya akun? <a href="/login">Login disini</a></p>
</body>
</html>