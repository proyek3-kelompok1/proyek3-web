<?php

use App\Http\Controllers\OnlineServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\Admin\EducationController as AdminEducationController;
use App\Http\Controllers\Admin\DoctorController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');

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
// Route untuk FRONTEND (halaman articles/edukasi yang dilihat user)
    Route::get('/articles', [EducationController::class, 'index'])->name('articles.index');
    Route::get('/articles/{id}', [EducationController::class, 'show'])->name('articles.show');
    // Route untuk lihat antrian
    Route::get('/online-services/queue', [OnlineServiceController::class, 'queue'])->name('online-services.queue');
    Route::get('/online-services/queue-data', [OnlineServiceController::class, 'getQueueData'])->name('online-services.queue-data');
    Route::post('/online-services/check-my-queue', [OnlineServiceController::class, 'checkMyQueue'])->name('online-services.check-my-queue');
    
    // Route untuk melihat jadwal jam dokter
    Route::get('/online-services/available-hours', [OnlineServiceController::class, 'getAvailableHours'])->name('online-services.available-hours');
    
    // Route untuk feedback
   // routes/web.php
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
    
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
    Route::resource('doctors', App\Http\Controllers\Admin\DokterController::class);
    Route::resource('/posts', App\Http\Controllers\Admin\PostController::class);
    Route::resource('/galleries', App\Http\Controllers\Admin\GalleryController::class);

    // Route untuk ADMIN (CRUD edukasi)
    Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
        Route::resource('education', AdminEducationController::class);
    });

    Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('doctors', DoctorController::class);
    });

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
