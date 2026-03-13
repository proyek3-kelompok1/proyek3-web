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
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\MedicalRecordController as AdminMedicalRecordController;
use Illuminate\Support\Facades\Route;

// =======================
// HALAMAN UTAMA
// =======================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () { return view('about'); })->name('about');

// Services
Route::get('/services', function () {
    $services = \App\Models\Service::active()->ordered()->get();
    $serviceTypes = [
        'all' => 'Semua Layanan',
        'general' => 'Umum',
        'vaccination' => 'Vaksinasi',
        'surgery' => 'Operasi',
        'grooming' => 'Grooming',
        'dental' => 'Perawatan Gigi',
        'laboratory' => 'Laboratorium',
        'inpatient' => 'Rawat Inap',
        'emergency' => 'Darurat'
    ];
    return view('services', compact('services', 'serviceTypes'));
})->name('services');

Route::get('/services/{id}/detail', function ($id) {
    $service = \App\Models\Service::active()->find($id);
    if (!$service) {
        return response()->json(['success' => false, 'message' => 'Layanan tidak ditemukan']);
    }
    return response()->json([
        'success' => true,
        'service' => [
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'details' => $service->details,
            'icon' => $service->icon,
            'price' => $service->price,
            'formatted_price' => $service->formatted_price,
            'duration_minutes' => $service->duration_minutes,
            'formatted_duration' => $service->formatted_duration,
            'service_type' => $service->service_type,
            'service_type_label' => $service->service_type_label
        ]
    ]);
})->name('services.detail');

// =======================
// CONSULTATIONS & FEEDBACK
// =======================
Route::get('/consultations', [ConsultationsController::class, 'showForm'])->name('consultations');
Route::post('/consultations', [ConsultationsController::class, 'store'])->name('consultations.store');

// =======================
// FEEDBACK ROUTES
// =======================
Route::prefix('feedback')->name('feedback.')->group(function () {
    // Store feedback dari consultation page (AJAX)
    Route::post('/consultation/store', [FeedbackController::class, 'storeFromConsultation'])
        ->name('consultation.store');
    
    // Get all feedback untuk consultation page (AJAX)
    Route::get('/', [FeedbackController::class, 'index'])->name('index');
    
    // Delete feedback (AJAX)
    Route::delete('/{id}', [FeedbackController::class, 'destroy'])->name('destroy');
    
    // Store feedback dari after service
    Route::post('/after-service/store', [FeedbackController::class, 'storeAfterService'])
        ->name('after-service.store');
});

// After services form page
Route::get('/after-services', function () {
    return view('after_services', [
        'service_type' => 'Konsultasi Umum',
        'doctor_name' => 'Dr. Ahmad Wijaya',
        'transaction_id' => 'TRX-' . date('Ymd') . '-' . rand(100, 999)
    ]);
})->name('after-services');

// =======================
// EDUCATION
// =======================
Route::get('/education', [EducationController::class, 'index'])->name('education.index');
Route::get('/education/{id}', [EducationController::class, 'show'])->name('education.show');

// =======================
// APPOINTMENTS & ONLINE SERVICES
// =======================
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments/success', [AppointmentController::class, 'success'])->name('appointments.success');

Route::prefix('online-services')->name('online-services.')->group(function () {
    Route::get('/', [OnlineServiceController::class, 'index'])->name('index');
    Route::post('/book', [OnlineServiceController::class, 'book'])->name('book');
    Route::get('/success', [OnlineServiceController::class, 'success'])->name('success');
    Route::get('/queue', [OnlineServiceController::class, 'queue'])->name('queue');
    Route::get('/queue-data', [OnlineServiceController::class, 'getQueueData'])->name('queue-data');
    Route::get('/queue-position', [OnlineServiceController::class, 'getQueuePosition'])->name('queue-position');
    Route::post('/check-my-queue', [OnlineServiceController::class, 'checkMyQueue'])->name('check-my-queue');
    Route::get('/available-hours', [OnlineServiceController::class, 'getAvailableHours'])->name('available-hours');
});

// =======================
// AUTHENTICATION - USER
// =======================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', function () { return view('dashboard'); })->middleware('auth')->name('dashboard');

// =======================
// MEDICAL RECORDS
// =======================
Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
Route::post('/medical-records/search', [MedicalRecordController::class, 'search'])->name('medical-records.search');
Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
Route::get('/medical-records/create/{bookingId}', [MedicalRecordController::class, 'createFromBooking'])->name('medical-records.create');
Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');

// =======================
// ADMIN AREA
// =======================
Route::prefix('admin')->group(function () {
    // Authentication - ADMIN
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    // Protected Admin Routes
    Route::middleware(['auth:admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Services
        Route::resource('services', ServiceController::class)->names([
            'index' => 'admin.services.index',
            'create' => 'admin.services.create',
            'store' => 'admin.services.store',
            'show' => 'admin.services.show',
            'edit' => 'admin.services.edit',
            'update' => 'admin.services.update',
            'destroy' => 'admin.services.destroy'
        ]);
        
        // Doctors
        Route::resource('doctors', DoctorController::class)->names([
            'index' => 'admin.doctors.index',
            'create' => 'admin.doctors.create',
            'store' => 'admin.doctors.store',
            'show' => 'admin.doctors.show',
            'edit' => 'admin.doctors.edit',
            'update' => 'admin.doctors.update',
            'destroy' => 'admin.doctors.destroy'
        ]);
        
        // Education
        Route::resource('education', AdminEducationController::class)->names([
            'index' => 'admin.education.index',
            'create' => 'admin.education.create',
            'store' => 'admin.education.store',
            'show' => 'admin.education.show',
            'edit' => 'admin.education.edit',
            'update' => 'admin.education.update',
            'destroy' => 'admin.education.destroy'
        ]);
        
        // Queue Management
        Route::prefix('queue')->name('admin.queue.')->group(function () {
            Route::get('/', [QueueController::class, 'index'])->name('index');
            Route::get('/data', [QueueController::class, 'getQueueData'])->name('data');
            Route::get('/{id}/detail', [QueueController::class, 'showDetail'])->name('detail');
            Route::get('/{id}', [QueueController::class, 'show'])->name('show');
            Route::put('/{id}/status', [QueueController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('/{id}', [QueueController::class, 'destroy'])->name('destroy');
        });
        
        // Medical Records
        Route::prefix('medical-records')->name('admin.medical-records.')->group(function () {
            Route::get('/', [AdminMedicalRecordController::class, 'index'])->name('index');
            Route::get('/create/{bookingId}', [AdminMedicalRecordController::class, 'create'])->name('create');
            Route::post('/', [AdminMedicalRecordController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminMedicalRecordController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminMedicalRecordController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminMedicalRecordController::class, 'update'])->name('update');
        });
        
        // Messages Management
        Route::prefix('messages')->name('admin.messages.')->group(function () {
            Route::get('/stats', [AdminMessageController::class, 'stats'])->name('stats');
            Route::get('/', [AdminMessageController::class, 'index'])->name('index');
            Route::get('/api', [AdminMessageController::class, 'api'])->name('api');
            Route::get('/{id}', [AdminMessageController::class, 'show'])->name('show');
            Route::delete('/{id}', [AdminMessageController::class, 'destroy'])->name('destroy');
        });
        
        // Posts
        Route::prefix('posts')->name('admin.posts.')->group(function () {
            Route::get('/', function() { return redirect()->route('admin.dashboard'); })->name('index');
        });
    });
});

// =======================
// ROUTE UNTUK DATABASE ERROR (FALLBACK)
// =======================
Route::fallback(function () {
    return response()->view('errors.database', [], 500);
});