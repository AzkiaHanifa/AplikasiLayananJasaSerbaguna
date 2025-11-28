<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});

// Auth
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Protected Routes (Middleware Role Based)
|--------------------------------------------------------------------------
*/

// ADMIN
Route::middleware(['auth', 'roles:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('jobs', JobController::class);
});

// USER
Route::middleware(['auth', 'roles:user'])
    ->prefix('user') 
    ->name('user.') // <-- Prefix nama 'user.'
    ->group(function () {
        
        // 1. Home
        Route::get('/home', [UserController::class, 'index'])->name('home');

        // 2. LIHAT PROFILE (Perbaiki baris ini)
        // Hapus '.show' agar sesuai dengan panggilan di view (user.profile)
        Route::get('/profile', [UserController::class, 'showProfile'])->name('profile'); 

        // 3. Edit & Update
        Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
});

// MITRA
Route::middleware(['auth', 'roles:mitra'])
    ->prefix('mitra')
    ->name('mitra.')
    ->group(function () {
        Route::get('/home', [MitraController::class, 'index'])->name('home');
});