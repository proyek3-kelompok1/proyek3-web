<?php
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AiController;

Route::get('/education', [EducationController::class, 'index']);
Route::get('/education/{id}', [EducationController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);

Route::get('/doctors', [DoctorController::class, 'index']);
Route::get('/doctors/{id}', [DoctorController::class, 'show']);

Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/bookings/queue', [BookingController::class, 'queue']);
Route::post('/bookings/check-queue', [BookingController::class, 'checkQueue']);

// Authentication Routes
Route::post('/auth/google', [AuthController::class, 'googleLogin']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/auth/resend-otp', [AuthController::class, 'resendOtp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/user/profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // AI & Chat
    Route::get('/ai/history', [AiController::class, 'getHistory']);
    Route::post('/ai/chat', [AiController::class, 'chat']);
});