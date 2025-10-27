<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\VehicleTypeController;

// Locations
Route::get('/locations', [LocationController::class, 'index']);

// Vehicle Types
Route::get('/vehicletypes', [VehicleTypeController::class, 'index']);