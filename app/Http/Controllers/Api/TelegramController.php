<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    private $botToken;
    private $apiUrl;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }

    public function handle(Request $request)
    {
        $update = $request->all();

        // Handle callback queries (inline button clicks)
        if (isset($update['callback_query'])) {
            $this->handleCallbackQuery($update['callback_query']);
            return response()->json(['status' => 'success']);
        }

        // Handle messages
        if (isset($update['message'])) {
            $message = $update['message'];
            $text = $message['text'] ?? null;

            $userInfo = $this->getUserInfo($message);
            $chatId = $userInfo['chat_id'];

            if ($text) {
                if ($text === '/start') {
                    $this->handleStartCommand($chatId);
                    return response()->json(['status' => 'success']);
                }

                if ($text === '/rentnow') {
                    $this->handleRentNowCommand($chatId);
                    return response()->json(['status' => 'success']);
                }
            }

            // Handle contact sharing
            if (isset($message['contact'])) {
                $this->handleContactSharing($message);
                return response()->json(['status' => 'success']);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Webhook received']);
    }

    private function sendMessage($chatId, $text)
    {
        $response = Http::post("{$this->apiUrl}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ]);

        return $response->json();
    }

    private function sendContactKeyboard($chatId, $text)
    {
        $keyboard = [
            'keyboard' => [
                [
                    [
                        'text' => '📞 Share Contact',
                        'request_contact' => true
                    ]
                ]
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ];

        return Http::post("{$this->apiUrl}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => json_encode($keyboard)
        ])->json();
    }

    private function handleStartCommand($chatId)
    {
        $this->sendMessage($chatId, "👋 Welcome to GoYan ✨\n\nYour vehicle renting assistant. Fast, easy, and reliable rentals in just a few taps.");
        $this->sendContactKeyboard($chatId, "📱 To get started, please share your phone number so we can confirm your bookings and contact you if needed.");
    }

    private function handleContactSharing($message)
    {
        $chatId = $message['chat']['id'] ?? null;
        $contact = $message['contact'] ?? [];
        $from = $message['from'] ?? [];

        \Log::info('Telegram contact data:', $contact);
        \Log::info('Telegram from data:', $from);

        $userData = [
            'telegram_id' => $contact['user_id'] ?? $from['id'] ?? $chatId,
            'username' => $from['username'] ?? null, // get username from sender
            'first_name' => $contact['first_name'] ?? $from['first_name'] ?? null,
            'last_name' => $contact['last_name'] ?? $from['last_name'] ?? null,
            'chat_id' => $chatId,
            'phone_number' => $contact['phone_number'] ?? null,
        ];

        $this->storeTelegramUser($userData);

        $this->sendMessage($chatId, "✅ Thanks, we got your number. You're now phone-verified with GoYan ✨");

        $this->handleRentNowCommand($chatId);
    }


    private function handleRentNowCommand($chatId)
    {
        $this->sendTextWithMiniAppButton($chatId);
    }

    private function sendTextWithMiniAppButton($chatId)
    {
        $miniAppUrl = env('MINI_APP_URL');

        // Build inline keyboard depending on whether MINI_APP_URL exists
        $inlineKeyboard = [
            'inline_keyboard' => [
                [
                    $miniAppUrl
                        ? ['text' => 'Start Now', 'web_app' => ['url' => $miniAppUrl]]
                        : ['text' => 'Start Renting', 'callback_data' => 'start_renting']
                ]
            ]
        ];

        // Send message with inline button
        return Http::post("{$this->apiUrl}/sendMessage", [
            'chat_id' => $chatId,
            'text' => "<b>Welcome to GoYan Vehicle Rental!</b>\n\nClick the button below to get started!",
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($inlineKeyboard),
        ])->json();
    }


    private function handleCallbackQuery($callbackQuery)
    {
        $chatId = $callbackQuery['message']['chat']['id'];
        $data = $callbackQuery['data'];
        $queryId = $callbackQuery['id'];

        switch ($data) {
            case 'start_renting':
                $this->sendMessage($chatId, "🚲 <b>Starting Bike Rental Process</b> 🚲\n\nSend /rentnow to start renting.");
                break;

            default:
                $this->sendMessage($chatId, "❓ Unknown action. Please try again.");
                break;
        }

        Http::post("{$this->apiUrl}/answerCallbackQuery", [
            'callback_query_id' => $queryId
        ]);
    }

    private function getUserInfo($message)
    {
        $user = $message['from'] ?? null;
        $chatId = $message['chat']['id'] ?? null;

        return [
            'telegram_id' => $user['id'] ?? null,
            'username' => $user['username'] ?? null,
            'first_name' => $user['first_name'] ?? null,
            'last_name' => $user['last_name'] ?? null,
            'chat_id' => $user['id'] ?? null,
            'user' => $user
        ];
    }

    private function storeTelegramUser(array $userData)
    {
        $validated = validator($userData, [
            'telegram_id' => 'required|integer',
            'username'    => 'nullable|string',
            'first_name'  => 'nullable|string',
            'last_name'   => 'nullable|string',
            'chat_id'     => 'required|integer',
            'phone_number'=> 'nullable|string',
        ])->validate();

        User::updateOrCreate(
            ['telegram_id' => $validated['telegram_id']], // find by telegram_id
            $validated                                    // update all other fields
        );

        return true;
    }
}
