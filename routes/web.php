<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchRoomController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StaffController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/search-room', [SearchRoomController::class, 'index']);

Route::get('/room/{id}', [RoomController::class, 'show']);

// Booking routes
Route::post('/book-room', [BookingController::class, 'bookRoom'])->name('booking.book');
Route::get('/booking/confirmation', [BookingController::class, 'confirmation'])->name('booking.confirmation');

// Profile routes
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

// Test route
Route::get('/test-booking', function () {
    return view('test-booking');
});

// Booking history routes
Route::get('/booking-history', [App\Http\Controllers\BookingHistoryController::class, 'index'])->name('booking.history');
Route::get('/booking/{id}', [App\Http\Controllers\BookingHistoryController::class, 'show'])->name('booking.detail');
Route::get('/booking-export', [App\Http\Controllers\BookingHistoryController::class, 'export'])->name('booking.export');

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

// Quản trị viên
Route::prefix('admin')->group(function () {
    Route::get('/rooms', [AdminController::class, 'rooms']);
    Route::post('/rooms', [AdminController::class, 'storeRoom']);
    Route::put('/rooms/{id}/status', [AdminController::class, 'updateRoomStatus']);
    Route::delete('/rooms/{id}', [AdminController::class, 'deleteRoom']);

    // Quản lý đơn đặt phòng
    Route::get('/bookings', [AdminController::class, 'bookings']);
    Route::match(['PUT', 'POST'], '/bookings/{id}/status', [AdminController::class, 'updateBookingStatus']);
    Route::delete('/bookings/{id}', [AdminController::class, 'deleteBooking']);

    Route::get('/staff/create', [StaffController::class, 'create']);
    Route::post('/staff', [StaffController::class, 'store']);
    Route::get('/staff', [StaffController::class, 'index']);
    Route::get('/staff/{id}/edit', [StaffController::class, 'edit']);
    Route::put('/staff/{id}', [StaffController::class, 'update']);
    Route::delete('/staff/{id}', [StaffController::class, 'destroy']);


});
