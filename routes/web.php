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
| Public Routes (Auth, Register, Root)
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Protected Routes (Middleware Role Based)
|--------------------------------------------------------------------------
*/

// ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin') // Semua URI di sini dimulai dengan /admin
    ->name('admin.')  // Semua nama route di sini dimulai dengan admin.
    ->group(function () {
        
        // Dashboard Admin
        // URL: /admin/dashboard
        // Name: admin.dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // CRUD Jobs (Menggunakan JobController)
        // URL: /admin/jobs, /admin/jobs/create, dll.
        // Names: admin.jobs.index, admin.jobs.store, dll.
        Route::resource('jobs', JobController::class);
});

// USER ROUTES
Route::middleware(['auth', 'role:user'])
    ->prefix('user') 
    ->name('user.')
    ->group(function () {
        
        // Home User
        // URL: /user/home
        // Name: user.home
        Route::get('/home', [UserController::class, 'index'])->name('home');
});

// MITRA ROUTES
Route::middleware(['auth', 'role:mitra'])
    ->prefix('mitra')
    ->name('mitra.')
    ->group(function () {
        
        // Home Mitra
        // URL: /mitra/home
        // Name: mitra.home
        Route::get('/home', [MitraController::class, 'index'])->name('home');
});