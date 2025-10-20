<?php

use App\Http\Controllers\OnlineServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

// =======================
// HALAMAN UTAMA
// =======================
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/consultations', [ConsultationsController::class, 'showForm'])->name('consultations');
Route::post('/consultations', [ConsultationsController::class, 'store']);
// Route untuk Artikel & Edukasi (gabungan)
Route::get('/articles', function () {
    return view('articles');
});
// =======================
// AUTENTIKASI USER (Login, Register, Logout)
// =======================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// =======================
// ADMIN AREA
// =======================
Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('/services', App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('/doctors', App\Http\Controllers\Admin\DokterController::class);
    Route::resource('/posts', App\Http\Controllers\Admin\PostController::class);
    Route::resource('/galleries', App\Http\Controllers\Admin\GalleryController::class);

    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/success', [AppointmentController::class, 'success'])->name('appointments.success');

    Route::get('/online-services', [OnlineServiceController::class, 'index'])->name('online-services.index');
    Route::post('/online-services/book', [OnlineServiceController::class, 'book'])->name('online-services.book');
    Route::get('/online-services/success', [OnlineServiceController::class, 'success'])->name('online-services.success');

    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::post('/medical-records/search', [MedicalRecordController::class, 'search'])->name('medical-records.search');
    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/medical-records/create/{bookingId}', [MedicalRecordController::class, 'createFromBooking'])->name('medical-records.create');
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
});
//feedback didalam halam kontak dan konsultasi
// Route::get('/feedbacks', [FeedbackController::class, 'index']);
// Route::post('/feedbacks', [FeedbackController::class, 'store']); 
// Route::delete('/feedbacks/{id}', [FeedbackController::class, 'destroy']);
