<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h1>Admin Dashboard</h1>

<p>Halo, <strong>{{ auth()->user()->name }}</strong></p>
<p>Role Anda: <strong>{{ auth()->user()->roles }}</strong></p>

<p>Status Auth: 
    @if(auth()->check())
        <span style="color:green;">Authenticated ✔</span>
    @else
        <span style="color:red;">Not Authenticated ✘</span>
    @endif
</p>

<p>Anda berhasil masuk sebagai <strong>ADMIN</strong>.</p>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

</body>
</html>
