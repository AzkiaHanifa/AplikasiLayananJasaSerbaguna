<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\VerifMitraController;
use App\Http\Controllers\User\UserJobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\MitraController;
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
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserManagementController::class);
        // Halaman List
    Route::get('/mitra/verifikasi', [VerifMitraController::class, 'index'])->name('mitra.index');
    
    // Action Approve
    Route::patch('/mitra/{id}/approve', [VerifMitraController::class, 'approve'])->name('mitra.approve');
    
    // Action Reject
    Route::patch('/mitra/{id}/reject', [VerifMitraController::class, 'reject'])->name('mitra.reject');
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

        // 4. Mitra Registration
        Route::get('/register-mitra', [MitraController::class, 'create'])->name('mitra.register');
        Route::post('/register-mitra', [MitraController::class, 'store'])->name('mitra.store');
        Route::get('/jobs/create', [UserJobController::class, 'create'])->name('jobs.create');
    
    // 2. Memproses Simpan Data (Store)
    Route::post('/jobs', [UserJobController::class, 'store'])->name('jobs.store');
});

// MITRA
Route::middleware(['auth', 'roles:mitra'])
    ->prefix('mitra')
    ->name('mitra.')
    ->group(function () {
        Route::get('/home', [MitraController::class, 'index'])->name('home');
});