<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        try {
            $locations = Location::all();

            return response()->json([
                'success' => true,
                'data' => $locations,
                'meta' => [
                    'count' => $locations->count(),
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
