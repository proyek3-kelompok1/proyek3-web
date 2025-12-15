<?php

use App\Http\Controllers\OnlineServiceController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\Admin\EducationController as AdminEducationController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminMessageController;
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
// Route untuk FRONTEND (halaman articles/edukasi yang dilihat user)
    Route::get('/education', [EducationController::class, 'index'])->name('education.index');
Route::get('/education/{id}', [EducationController::class, 'show'])->name('education.show');
    // Route untuk lihat antrian
    Route::get('/online-services/queue', [OnlineServiceController::class, 'queue'])->name('online-services.queue');
    Route::get('/online-services/queue-data', [OnlineServiceController::class, 'getQueueData'])->name('online-services.queue-data');
    Route::post('/online-services/check-my-queue', [OnlineServiceController::class, 'checkMyQueue'])->name('online-services.check-my-queue');
    
    // Route untuk melihat jadwal jam dokter
    Route::get('/online-services/available-hours', [OnlineServiceController::class, 'getAvailableHours'])->name('online-services.available-hours');
    
    // Route untuk feedback
  Route::middleware('web')->group(function () {
    // Route untuk feedback dari after_service (biasa)
    Route::post('/feedback/after-service', [FeedbackController::class, 'storeAfterService'])
        ->name('feedback.after-service.store');
    
    // Route untuk feedback dari consultation page (AJAX)
    Route::post('/feedback/consultation', [FeedbackController::class, 'storeFromConsultation'])
        ->name('feedback.consultation.store');
    
    // Route untuk mengambil feedback (AJAX)
    Route::get('/feedback', [FeedbackController::class, 'index'])
        ->name('feedback.index');
    
    // Route untuk menghapus feedback (AJAX)
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])
        ->name('feedback.destroy');
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
    Route::resource('doctors', App\Http\Controllers\Admin\DoctorController::class);
    Route::resource('/posts', App\Http\Controllers\Admin\PostController::class);
    Route::resource('/galleries', App\Http\Controllers\Admin\GalleryController::class);

        Route::get('/', [AdminMessageController::class, 'index'])->name('admin.messages.index');
        Route::get('/api', [AdminMessageController::class, 'api'])->name('admin.messages.api');
        Route::get('/{id}', [AdminMessageController::class, 'show'])->name('admin.messages.show');
        Route::delete('/{id}', [AdminMessageController::class, 'destroy'])->name('admin.messages.destroy');

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
    
    // Admin Queue Routes
    Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/queue', [App\Http\Controllers\Admin\QueueController::class, 'index'])->name('queue.index');
    Route::get('/queue/data', [App\Http\Controllers\Admin\QueueController::class, 'getQueueData'])->name('queue.data');
    Route::get('/queue/{booking}', [App\Http\Controllers\Admin\QueueController::class, 'show'])->name('queue.show');
    Route::put('/queue/{booking}/status', [App\Http\Controllers\Admin\QueueController::class, 'updateStatus'])->name('queue.status');
    Route::delete('/queue/{booking}', [App\Http\Controllers\Admin\QueueController::class, 'destroy'])->name('queue.destroy');
    Route::prefix('queue')->name('queue.')->group(function () {
        Route::get('/', [QueueController::class, 'index'])->name('index');
        Route::get('/data', [QueueController::class, 'getQueueData'])->name('data');
        Route::get('/{id}/detail', [QueueController::class, 'showDetail'])->name('detail');
        Route::get('/{id}', [QueueController::class, 'show'])->name('show');
        Route::put('/{id}/status', [QueueController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [QueueController::class, 'destroy'])->name('destroy'); // PASTIKAN INI ADA
        

        
    });
    
    Route::get('/medical-records', [App\Http\Controllers\Admin\MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/create/{bookingId}', [App\Http\Controllers\Admin\MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [App\Http\Controllers\Admin\MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/{id}', [App\Http\Controllers\Admin\MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/medical-records/{id}/edit', [App\Http\Controllers\Admin\MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::put('/medical-records/{id}', [App\Http\Controllers\Admin\MedicalRecordController::class, 'update'])->name('medical-records.update');
    
    
});
});
    


// Route untuk form rating setelah layanan
Route::get('/after_services', function () {
    // Data ini biasanya berasal dari database berdasarkan layanan yang selesai
    return view('/after_services', [
        'service_type' => 'Konsultasi Umum',
        'doctor_name' => 'Dr. Ahmad Wijaya',
        'transaction_id' => 'TRX-' . date('Ymd') . '-' . rand(100, 999)
    ]);
})->name('feedback.after.services.form');

// Route untuk menyimpan feedback setelah layanan
Route::post('/after_services', [FeedbackController::class, 'storeAfterService'])->name('feedback.store.after.services');
