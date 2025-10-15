<?php

use App\Http\Controllers\ConsultationsController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/consultations', [ConsultationsController::class, 'showForm'])->name('consultations');
Route::post('/consultations', [ConsultationsController::class, 'store']);


// Admin Routes
Route::prefix('admin')->group(function () {
    // Login Routes
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Kelola Layanan (Services)
    Route::resource('/services', App\Http\Controllers\Admin\ServiceController::class);

    // Kelola Dokter (Doctors)
    Route::resource('/doctors', App\Http\Controllers\Admin\DokterController::class);

    // Kelola Artikel (Posts)
    Route::resource('/posts', App\Http\Controllers\Admin\PostController::class);

    // Kelola Galeri (Gallery)
    Route::resource('/galleries', App\Http\Controllers\Admin\GalleryController::class);

});