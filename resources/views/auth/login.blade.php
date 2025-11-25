<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <input type="nama" name="nama" placeholder="Nama" required autofocus>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        @if($errors->any())
            <div>{{ $errors->first() }}</div>
        @endif
    </form>
    <button onclick="location.href='register'">daftar</button>
</body>
</html>