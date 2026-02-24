<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderNotificationService
{
    /* ==========================
        SEND SMS VIA FAST2SMS
    ==========================*/
    public static function sendSMS($mobile, $message)
    {
        $apiKey = config('services.fast2sms.key');

        // ensure 10 digit
        $mobile = substr(preg_replace('/\D/', '', $mobile), -10);

        $response = Http::withHeaders([
            'authorization' => $apiKey,
            'accept' => 'application/json'
        ])->post('https://www.fast2sms.com/dev/bulkV2', [
            'route' => 'q',
            'message' => $message,
            'language' => 'english',
            'flash' => 0,
            'numbers' => $mobile
        ]);

        Log::info('Fast2SMS', [
            'mobile' => $mobile,
            'response' => $response->json()
        ]);
    }

    /* ==========================
        SEND WHATSAPP MESSAGE
    ==========================*/
    public static function sendWhatsApp($mobile, $message)
    {
        $token = config('services.whatsapp.token');
        $phoneId = config('services.whatsapp.phone_id');

        Http::withToken($token)
            ->post("https://graph.facebook.com/v18.0/$phoneId/messages", [
                "messaging_product" => "whatsapp",
                "to" => $mobile,
                "type" => "text",
                "text" => [
                    "body" => $message
                ]
            ]);
    }
}