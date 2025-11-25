<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MitraController;

Route::get('/', function () {
    return redirect('/login');
});

// login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});

// user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/home', [UserController::class, 'index']);
});

// mitra
Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/mitra/home', [MitraController::class, 'index']);
});
