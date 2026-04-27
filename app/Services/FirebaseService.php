<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    /**
     * Send Push Notification using FCM (Legacy API for simplicity)
     * Note: In production, consider using Firebase Admin SDK or V1 API
     */
    public static function sendNotification($fcmToken, $title, $body, $data = [])
    {
        $serverKey = config('services.firebase.server_key');
        
        if (!$serverKey || !$fcmToken) {
            Log::warning("FCM: Missing server key or token. Cannot send notification.");
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                ],
                'data' => $data,
            ]);

            Log::info("FCM Response: " . $response->body());
            return $response->successful();
        } catch (\Exception $e) {
            Log::error("FCM Error: " . $e->getMessage());
            return false;
        }
    }
}
