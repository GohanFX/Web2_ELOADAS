<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;

// Home page - Főoldal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::get('/auth/login', [Auth::class, 'showLogin'])->name('login');
Route::post('/auth/login', [Auth::class, 'login']);
Route::get('/auth/register', [Auth::class, 'showRegister'])->name('register');
Route::post('/auth/register', [Auth::class, 'register']);
Route::post('/auth/logout', [Auth::class, 'logout'])->name('logout');

// Contact form - Kapcsolat menü
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Database view - Adatbázis menü
Route::get('/database', [DashboardController::class, 'database'])->name('database.index');

// Chart - Diagram menü
Route::get('/chart', [DashboardController::class, 'chart'])->name('chart.index');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Messages - Üzenetek menü (registered users)
    Route::get('/messages', [ContactController::class, 'index'])->name('messages.index');

    // CRUD for contacts (admin)
    Route::resource('contacts', ContactController::class)->only(['edit','update','destroy']);

    // Admin routes - Admin menü (admin only)
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.index');

        // CRUD for drivers
        Route::resource('drivers', DriverController::class)->except(['show']);
    });
});


