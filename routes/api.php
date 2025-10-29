<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\VehicleTypeController;
use App\Http\Controllers\Api\VehicleController;

// Locations
Route::get('/locations', [LocationController::class, 'index']);

// Vehicle Types
Route::get('/vehicletypes', [VehicleTypeController::class, 'index']);

// Vehicles
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);