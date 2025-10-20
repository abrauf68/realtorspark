<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class FacebookHelper
{
    public static function sendEvent($eventName, $eventData = [])
    {
        $pixelId = config('services.facebook.pixel_id');
        $accessToken = config('services.facebook.access_token');

        $url = "https://graph.facebook.com/v20.0/{$pixelId}/events";

        $response = Http::post($url, [
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
        ]);

        return $response->json();
    }
}
