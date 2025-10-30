<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\VehicleTypeController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TelegramController;
use App\Http\Controllers\Api\BookingController;

// Locations
Route::get('/locations', [LocationController::class, 'index']);

// Vehicle Types
Route::get('/vehicletypes', [VehicleTypeController::class, 'index']);

// Vehicles
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

// Users
Route::get('/users/{telegramId}', [UserController::class, 'show']);

// Telegram webhook routes
Route::post('/telegram/webhook', [TelegramController::class, 'handle']);

// Booking notifications
Route::post('/booking/notify', [BookingController::class, 'sendBookingNotification']);