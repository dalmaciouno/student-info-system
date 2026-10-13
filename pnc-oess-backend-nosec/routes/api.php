<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClearanceController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\DevActor;
use Illuminate\Support\Facades\Route;

// NO-SECURITY VERSION: no auth:sanctum, no role checks, no login throttle.
// Every endpoint is open to anyone who can reach the server.

Route::get('/health', fn () => response()->json(['status' => 'ok']));
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(DevActor::class)->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Settings
    Route::get('/settings', [SettingsController::class, 'show']);
    Route::put('/settings', [SettingsController::class, 'update']);

    // Users + audit logs
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus']);
    Route::get('/audit-logs', [AuditLogController::class, 'index']);

    // Students
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{studentNumber}', [StudentController::class, 'show']);

    // Terms, offerings, enrollments
    Route::get('/terms', [EnrollmentController::class, 'terms']);
    Route::get('/offerings', [EnrollmentController::class, 'offerings']);
    Route::post('/offerings', [EnrollmentController::class, 'storeOffering']);
    Route::put('/offerings/{id}', [EnrollmentController::class, 'updateOffering']);
    Route::get('/enrollments', [EnrollmentController::class, 'index']);
    Route::post('/enrollments', [EnrollmentController::class, 'store']);
    Route::patch('/enrollments/{id}/status', [EnrollmentController::class, 'updateStatus']);

    // Payments
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::patch('/payments/{id}/verify', [PaymentController::class, 'verify']);

    // Clearances
    Route::get('/clearances', [ClearanceController::class, 'index']);
    Route::patch('/clearances/{id}/sign', [ClearanceController::class, 'sign']);

    // Grades
    Route::get('/grades', [GradeController::class, 'index']);
    Route::post('/grades', [GradeController::class, 'store']);
    Route::patch('/grades/{id}/validate', [GradeController::class, 'validateGrade']);

    // Document requests
    Route::get('/document-requests', [DocumentRequestController::class, 'index']);
    Route::post('/document-requests', [DocumentRequestController::class, 'store']);
    Route::patch('/document-requests/{id}/status', [DocumentRequestController::class, 'updateStatus']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markRead']);
});
