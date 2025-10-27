<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;

// Locations
Route::get('/locations', [LocationController::class, 'index']);