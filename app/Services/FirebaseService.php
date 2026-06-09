<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $credentialsPath = storage_path('app/firebase-auth.json');
        
        if (file_exists($credentialsPath)) {
            $factory = (new Factory)->withServiceAccount($credentialsPath);
            $this->messaging = $factory->createMessaging();
            Log::info('Firebase credentials loaded successfully.');
        } else {
            Log::error('Firebase credentials not found at ' . $credentialsPath);
        }
    }

    /**
     * Send notification to a specific FCM token
     */
    public function sendNotification($token, $title, $body, $data = [])
    {
        if (!$this->messaging || !$token) {
            return false;
        }

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification)
                ->withData($data);

            $messageId = $this->messaging->send($message);
            Log::info('FCM Notification sent successfully to token. Message ID: ' . $messageId);
            return true;
        } catch (\Exception $e) {
            Log::error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send notification to multiple tokens
     */
    /**
     * Send notification to multiple tokens
     */
    public function sendToMultiple(array $tokens, string $title, string $body, array $data = []): bool
    {
        if (!$this->messaging) {
            Log::error('Firebase messaging not initialized.');
            return false;
        }
        if (empty($tokens)) {
            Log::warning('sendToMultiple called with empty token list.');
            return false;
        }
        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withData($data);

            // Send multicast and capture the report
            $report = $this->messaging->sendMulticast($message, $tokens);
            // Log success and failure counts
            Log::info('FCM Multicast sent. Success: ' . $report->successCount() . ', Failure: ' . $report->failureCount());
            if ($report->hasFailures()) {
                foreach ($report->failures() as $failure) {
                    Log::error('FCM Multicast failure: ' . $failure->error()->getMessage());
                }
                return false;
            }
            return true;
        } catch (\Exception $e) {
            Log::error('FCM Multicast Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send notification to a topic
     */
    public function sendToTopic($topic, $title, $body, $data = [])
    {
        if (!$this->messaging) {
            return false;
        }

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::withTarget('topic', $topic)
                ->withNotification($notification)
                ->withData($data);

            $messageId = $this->messaging->send($message);
            Log::info('FCM Topic notification sent successfully to topic: ' . $topic . '. Message ID: ' . $messageId);
            return true;
        } catch (\Exception $e) {
            Log::error('FCM Topic Error: ' . $e->getMessage());
            return false;
        }
    }
}
