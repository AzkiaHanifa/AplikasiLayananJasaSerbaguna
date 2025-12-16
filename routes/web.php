<?php

use Illuminate\Support\Facades\Route;
// Import Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingController;

// Controller ADMIN
use App\Http\Controllers\Admin\JobController; // Controller untuk Admin
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\VerifMitraController;

// Controller USER
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\MitraController;
use App\Http\Controllers\User\UserJobController; // Controller untuk User

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

/*Route::get('/', function () {
    return view('index');
});*/

Route::get('/', [LandingController::class, 'index'])->name('home.landing');
Route::get('/jasa/{id}', [LandingController::class, 'show'])->name('job.show');

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

// ================= ADMIN =================
Route::middleware(['auth', 'roles:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Resource Admin
        Route::resource('jobs', JobController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserManagementController::class);
        
        // Verifikasi Mitra
        Route::get('/mitra/verifikasi', [VerifMitraController::class, 'index'])->name('mitra.index');
        Route::patch('/mitra/{id}/approve', [VerifMitraController::class, 'approve'])->name('mitra.approve');
        Route::patch('/mitra/{id}/reject', [VerifMitraController::class, 'reject'])->name('mitra.reject');
});

// ================= USER =================
Route::middleware(['auth', 'roles:user'])
    ->prefix('user') 
    ->name('user.') // Group ini otomatis menambahkan awalan 'user.' pada nama route
    ->group(function () {
        
        // 1. Home
        Route::get('/home', [UserController::class, 'index'])->name('home');

        // 2. Profile
        Route::get('/profile', [UserController::class, 'showProfile'])->name('profile'); 
        Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');

        // 3. Mitra Registration
        Route::get('/register-mitra', [MitraController::class, 'create'])->name('mitra.register');
        Route::post('/register-mitra', [MitraController::class, 'store'])->name('mitra.store');

        // 4. JOB MANAGEMENT (UserJobController)
        
        // Route Gatekeeper (Cek Create atau Edit)
        // URL: /user/jobs/manage | Name: user.jobs.manage
        Route::get('/jobs/manage', [UserJobController::class, 'manage'])->name('jobs.manage');

        // Route Resource CRUD (Create, Store, Edit, Update, Destroy)
        // Menggunakan UserJobController, BUKAN JobController (Admin)
        // URL: /user/jobs... | Name: user.jobs.create, user.jobs.store, dll
        Route::resource('jobs', UserJobController::class);
});

// ================= MITRA =================
Route::middleware(['auth', 'roles:mitra'])
    ->prefix('mitra')
    ->name('mitra.')
    ->group(function () {
        Route::get('/home', [MitraController::class, 'index'])->name('home');
});