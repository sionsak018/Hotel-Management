<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ApiController;

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    // Room APIs
    Route::get('/rooms/{room}', [ApiController::class, 'getRoom']);
    Route::post('/rooms/{room}/status', [ApiController::class, 'updateRoomStatus']);
    Route::get('/available-rooms', [ApiController::class, 'getAvailableRooms']);

    // Guest APIs
    Route::get('/guests/{guest}', [ApiController::class, 'getGuest']);
    Route::get('/search-guests', [ApiController::class, 'searchGuests']);

    // Booking APIs
    Route::post('/bookings/{booking}/check-in', [ApiController::class, 'checkIn']);
    Route::post('/bookings/{booking}/check-out', [ApiController::class, 'checkOut']);

    // Dashboard APIs
    Route::get('/dashboard/stats', [ApiController::class, 'getDashboardStats']);
    Route::get('/recent-activities', [ApiController::class, 'getRecentActivities']);

    // Notification APIs
    Route::get('/notifications', [ApiController::class, 'getNotifications']);
    Route::get('/notifications/unread-count', [ApiController::class, 'getUnreadNotificationCount']);
    Route::post('/notifications/{notification}/read', [ApiController::class, 'markNotificationAsRead']);
    Route::post('/notifications/read-all', [ApiController::class, 'markAllNotificationsAsRead']);
});
