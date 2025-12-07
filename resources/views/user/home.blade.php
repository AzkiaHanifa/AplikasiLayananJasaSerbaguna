@extends('layouts.user.main')

@section('content')
    
<div class="container mt-5">
<br><br><br><br><br><br>
    <h1>User Home Page</h1>
    
    <p>Halo, <strong>{{ auth()->user()->nama }}</strong></p>
    <p>Role Anda: <strong>{{ auth()->user()->roles }}</strong></p>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-primary btn">Logout</button>
    </form>
</div>

@endsection
