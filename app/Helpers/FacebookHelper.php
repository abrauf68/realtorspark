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
        $testCode = config('services.facebook.test_event_code'); // 👈 optional line

        $url = "https://graph.facebook.com/v20.0/{$pixelId}/events";

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
                        'em' => [hash('sha256', strtolower(trim($eventData['custom_fields']['email'] ?? '')))],
                        'ph' => [hash('sha256', preg_replace('/\D+/', '', $eventData['custom_fields']['phone'] ?? ''))],
                    ],
                    'custom_data' => $eventData,
                ]],
                'access_token' => $accessToken,
            ];

            // 👇 only add this if test code exists
            if ($testCode) {
                $payload['test_event_code'] = $testCode;
            }

            Log::info('📦 Facebook CAPI Payload', $payload);

            $response = Http::post($url, $payload);

            Log::info('✅ Facebook CAPI Response', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return $response->json();
        } catch (\Throwable $e) {
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
