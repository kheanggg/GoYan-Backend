<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    /**
     * Handle GET /api/vehicles
     * Supports filters via query params:
     * - location: e.g. "phnom_penh"
     * - start / end: accepted but ignored in logic
     * - type: e.g. "bicycle" or "motorcycle"
     * - per_page: pagination limit
     */
    public function index(Request $request)
    {
        try {
            // === Query Parameters ===
            $location = $request->query('location');
            $start = $request->query('start'); // accepted but unused
            $end = $request->query('end');     // accepted but unused
            $type = $request->query('type');
            $perPage = (int) $request->query('per_page', 10);

            // === Base Query ===
            $query = Vehicle::with(['shop', 'media']);

            // filter by type (bicycle / motorcycle)
            if (!empty($type)) {
                $query->where('vehicle_type_id', $type);
            }

            // filter by location (based on shop relation)
            if (!empty($location)) {
                $query->whereHas('shop', function ($q) use ($location) {
                    $q->where('location_id', $location);
                });
            }

            // paginate results
            $vehicles = $query->paginate($perPage)->appends($request->query());

            // map the underlying collection safely
            $mapped = $vehicles->getCollection()->map(function ($v) {
                // safe accessors
                $shop = $v->shop ?? null;
                $firstMedia = ($v->media && $v->media->count()) ? $v->media->first() : null;

                $imageUrl = $firstMedia
                    ? asset(ltrim($firstMedia->media_url, '/'))
                    : asset('images/default-vehicle.png');

                return [
                    'id' => $v->vehicle_id ?? null,
                    'name' => $v->vehicle_name ?? null,
                    'type' => $v->vehicle_type_id ?? null,
                    'brand' => $v->brand ?? null,
                    'model' => $v->model ?? null,
                    'year' => is_numeric($v->year) ? (int) $v->year : null,
                    'color' => $v->color ?? null,
                    'rental_price_per_day' => is_numeric($v->rental_price_per_day) ? (float) $v->rental_price_per_day : null,
                    'currency' => $v->currency ?? 'USD',
                    'description' => $v->description ?? null,
                    'available' => true, // For demo, always true
                    'shop' => $shop ? [
                        'id' => $shop->shop_id ?? null,
                        'name' => $shop->shop_name ?? null,
                        'location' => $shop->location_id ?? null,
                        'address' => $shop->address ?? null,
                        'phone_number' => $shop->phone_number ?? null,
                    ] : null,
                    'media' => [
                        [
                            'type' => $firstMedia->media_type ?? 'image',
                            'url' => $imageUrl,
                        ]
                    ]
                ];
            });

            // convert to plain array for JSON response
            $formatted = $mapped->values()->all();

            // === Build Meta & Links ===
            $meta = [
                'total' => $vehicles->total(),
                'page' => $vehicles->currentPage(),
                'per_page' => $vehicles->perPage(),
                'last_page' => $vehicles->lastPage(),
                'filters' => [
                    'location' => $location,
                    'start' => $start,
                    'end' => $end,
                    'type' => $type,
                ],
            ];

            $links = [
                'self' => $request->fullUrl(),
                'first' => $vehicles->url(1),
                'prev' => $vehicles->previousPageUrl(),
                'next' => $vehicles->nextPageUrl(),
                'last' => $vehicles->url($vehicles->lastPage()),
            ];

            // === Response ===
            return response()->json([
                'success' => true,
                'data' => $formatted,
                'meta' => $meta,
                'links' => $links,
                'errors' => null,
            ], 200);

        } catch (\Throwable $e) {
            Log::error('VehicleController@index error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'data' => null,
                'meta' => null,
                'links' => null,
                'errors' => [
                    'code' => 'SERVER_ERROR',
                    'message' => 'An unexpected error occurred. Please try again later.'
                ],
            ], 500);
        }
    }
}
