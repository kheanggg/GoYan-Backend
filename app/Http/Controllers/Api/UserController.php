<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show($telegramId)
    {
        try {
            // Ensure we compare against the correct type (string/number)
            $user = User::where('telegram_id', $telegramId)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'meta' => null,
                    'links' => null,
                    'errors' => [
                        'message' => 'User not found',
                    ],
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $user,
                'meta' => null, // single resource — keep null or include useful info if you want
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
