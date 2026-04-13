<?php

use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransactionController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Guest: Welcome, Login & Register
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('register.post');

// Auth: Hanya untuk yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:' . User::ROLE_CUSTOMER])->group(function () {
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.index');
    Route::post('/booking/{id}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/history', [BookingController::class, 'history'])->name('booking.history');
    Route::get('/bookings/{booking}/ticket', [BookingController::class, 'ticket'])->name('booking.ticket');
    Route::get('/bookings/{booking}/payment', [TransactionController::class, 'create'])->name('payment.create');
    Route::post('/bookings/{booking}/payment', [TransactionController::class, 'store'])->name('payment.store');
});

Route::middleware(['auth', 'role:' . User::ROLE_ADMIN])->group(function () {
    Route::get('/admin/schedules/create', [AdminScheduleController::class, 'create']);
    Route::post('/admin/schedules/store', [AdminScheduleController::class, 'store']);
    Route::get('/admin/schedules/edit/{id}', [AdminScheduleController::class, 'edit']);
    Route::post('/admin/schedules/update/{id}', [AdminScheduleController::class, 'update']);
    Route::get('/admin/schedules/delete/{id}', [AdminScheduleController::class, 'destroy']);

    Route::post('/admin/bookings/approve/{booking}', [AdminBookingController::class, 'approve'])->name('admin.bookings.approve');
});
