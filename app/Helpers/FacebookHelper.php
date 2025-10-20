<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookHelper
{
    public static function sendEvent($eventName, $eventData = [])
    {
        $pixelId = config('services.facebook.pixel_id');
        $accessToken = config('services.facebook.access_token');

        $url = "https://graph.facebook.com/v20.0/{$pixelId}/events";

        // 📘 Log: Starting event
        Log::info('📤 Sending Facebook CAPI Event', [
            'pixel_id' => $pixelId,
            'event_name' => $eventName,
            'event_data' => $eventData,
        ]);

        try {
            $payload = [
                'data' => [[
                    'event_name' => $eventName,
                    'event_time' => time(),
                    'action_source' => 'website',
                    'user_data' => [
                        'client_ip_address' => request()->ip(),
                        'client_user_agent' => request()->userAgent(),
                    ],
                    'custom_data' => $eventData,
                ]],
                'access_token' => $accessToken,
            ];

            // 📘 Log request payload before sending
            Log::info('📦 Facebook CAPI Payload', $payload);

            $response = Http::post($url, $payload);

            // 📘 Log Facebook response
            Log::info('✅ Facebook CAPI Response', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return $response->json();
        } catch (\Throwable $e) {
            // 📕 Log any exception that occurs
            Log::error('❌ Facebook CAPI Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
