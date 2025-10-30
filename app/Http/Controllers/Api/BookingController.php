<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Shop;

class BookingController extends Controller
{
    private $botToken;
    private $apiUrl;
    private $shopOwnerTelegramId;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->shopOwnerTelegramId = env('SHOP_OWNER_TELEGRAM_ID');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }

    // Send a Telegram message
    private function sendMessage($chatId, $text, $inlineKeyboard = null)
    {
        $payload = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ];

        if ($inlineKeyboard) {
            $payload['reply_markup'] = json_encode($inlineKeyboard);
        }

        return Http::post("{$this->apiUrl}/sendMessage", $payload)->json();
    }

    // Send booking notifications without storing in DB
    public function sendBookingNotification(Request $request)
    {
        $validated = $request->validate([
            'user_telegram_id' => 'required|numeric',
            'user_name' => 'required|string',
            'user_username' => 'nullable|string',
            'user_phone' => 'nullable|string',
            'shop_name' => 'required|string',
            'province' => 'required|string',
            'vehicle' => 'required|string',
            'payment_method' => 'required|string',
            'rent_date' => 'required|string',
        ]);

        $customerMessage = "✅ You've made a Booking!\n\n"
                 . "🚗 Vehicle: {$validated['vehicle']}\n"
                 . "🗓️ Date: {$validated['rent_date']}\n"
                 . "🏪 Shop: {$validated['shop_name']}\n\n"
                 . "📍 Province: {$validated['province']}\n\n"
                 . "Thank you for booking with us!";


        $this->sendMessage($validated['user_telegram_id'], $customerMessage);

        $shopMessage = "🚨 New Booking! 🚨\n\n" 
             . "👤 {$validated['user_name']} (@{$validated['user_username']})\n"
             . "📞 Phone: {$validated['user_phone']}\n"
             . "🚗 Vehicle: {$validated['vehicle']}\n"
             . "💰 Payment: {$validated['payment_method']}\n"
             . "🗓️ Date: {$validated['rent_date']}\n"
             . "✅ Please prepare the vehicle and confirm the booking.";

        $inlineKeyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Chat with Customer',
                        'url' => "https://t.me/{$validated['user_username']}"
                    ]
                ]
            ]
        ];

        $this->sendMessage($this->shopOwnerTelegramId, $shopMessage, $inlineKeyboard);

        return response()->json([
            'success' => true,
            'message' => 'Booking notifications sent'
        ]);
    }
}
