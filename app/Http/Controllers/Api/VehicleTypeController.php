<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleType;

class VehicleTypeController extends Controller
{
    // Display a listing of vehicle types
    public function index()
    {
        try {
            $vehicletypes = VehicleType::all();

            return response()->json([
                'success' => true,
                'data' => $vehicletypes,
                'meta' => [
                    'count' => $vehicletypes->count(),
                ],
                'errors' => null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => null,
                'meta' => null,
                'links' => null,
                'errors' => [
                    'message' => $e->getMessage(),
                ],
            ], 500);
        }
    }
}
