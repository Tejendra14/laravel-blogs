<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\Auth\SuperAdminLoginController;
use App\Http\Controllers\SuperAdmin\UserManagementController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\PermissionController;
use App\Http\Controllers\SuperAdmin\SuperAdminPostController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});

// User Authentication Routes
Route::prefix('auth')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('user.login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Super Admin Routes
Route::prefix('superadmin')->group(function () {
    // Authentication routes
    Route::get('/login', [SuperAdminLoginController::class, 'showLoginForm'])->name('superadmin.login');
    Route::post('/login', [SuperAdminLoginController::class, 'login'])->name('superadmin.login.submit');
    Route::post('/logout', [SuperAdminLoginController::class, 'logout'])->name('superadmin.logout');
    // Protected superadmin routes
    Route::middleware(['auth:superadmin'])->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');

        // Super Admin User Management Routes
        Route::get('/users', [UserManagementController::class, 'index'])->name('superadmin.users.index');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('superadmin.users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('superadmin.users.store');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('superadmin.users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('superadmin.users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('superadmin.users.destroy');

        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);
        
        Route::prefix('posts')->group(function () {
            Route::get('/', [SuperAdminPostController::class, 'index'])->name('superadmin.posts.index');
            Route::get('/{post}', [SuperAdminPostController::class, 'show'])->name('superadmin.posts.show');
            Route::post('/{post}/approve', [SuperAdminPostController::class, 'approve'])->name('superadmin.posts.approve');
            Route::post('/{post}/reject', [SuperAdminPostController::class, 'reject'])->name('superadmin.posts.reject');
        });
    });
});

// Shared Post Routes for Authors and Admins (Only Admin role allowed)
Route::middleware(['auth', 'role:admin,author'])->prefix('posts')->name('admin.posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::post('/', [PostController::class, 'store'])->name('store');
    Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
    Route::put('/{post}', [PostController::class, 'update'])->name('update');
    Route::get('/{post}', [PostController::class, 'show'])->name('show');
     
   
});
Route::middleware(['auth', 'role:admin,author'])->group(function () {
Route::resource('categories', CategoryController::class)->except(['show']);

});
// Admin-only Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', AdminUserController::class)->except(['show']);
     // Additional post routes
    Route::get('/pending', [PostController::class, 'pending'])->name('pending');
    Route::post('/{post}/approve', [PostController::class, 'approve'])->name('admin.posts.approve');
    Route::post('/{post}/reject', [PostController::class, 'reject'])->name('admin.posts.reject');
    Route::post('/{post}/submit', [PostController::class, 'submitForReview'])->name('admin.posts.submit');
     Route::delete('/{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
});
Route::get('/test-email', function() {
    try {
        Mail::raw('This is a test email', function($message) {
            $message->to('test@example.com')
                    ->subject('Test Email');
        });
        return "Email sent successfully!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});