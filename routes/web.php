<?php
use App\Http\Controllers\OnlineServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\MedicalRecordController;
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
    // Route coba-coba janji temu
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/success', [AppointmentController::class, 'success'])->name('appointments.success');
    // Kelola Pesan (Contacts)
    // Route::get('/contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin.contacts.index');
    // Route::delete('/contacts/{id}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('admin.contacts.destroy');

    // Route Pemesanan Layanan Online
    Route::get('/online-services', [OnlineServiceController::class, 'index'])->name('online-services.index');
    Route::post('/online-services/book', [OnlineServiceController::class, 'book'])->name('online-services.book');
    Route::get('/online-services/success', [OnlineServiceController::class, 'success'])->name('online-services.success');
    
    // Route untuk rekam medis
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::post('/medical-records/search', [MedicalRecordController::class, 'search'])->name('medical-records.search');
    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show'])->name('medical-records.show');

    // Route untuk admin/dokter (bisa diproteksi dengan auth)
    Route::get('/medical-records/create/{bookingId}', [MedicalRecordController::class, 'createFromBooking'])->name('medical-records.create');
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
});


// Route untuk admin (jika perlu login, tambahkan auth middleware)
// Route::middleware(['auth'])->group(function () {
//     // Route::get('/admin/consultations', [ConsultationController::class, 'index'])->name('admin.consultations');
//     // Route::put('/admin/consultations/{id}', [ConsultationController::class, 'updateStatus'])->name('admin.consultations.update');
// });


// ini adalah untuk login
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
//ini adalah untuk login