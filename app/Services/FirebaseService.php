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

            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            Log::error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send notification to multiple tokens
     */
    public function sendToMultiple($tokens, $title, $body, $data = [])
    {
        if (!$this->messaging || empty($tokens)) {
            return false;
        }

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withData($data);

            $this->messaging->sendMulticast($message, $tokens);
            return true;
        } catch (\Exception $e) {
            Log::error('FCM Multicast Error: ' . $e->getMessage());
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

            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            Log::error('FCM Topic Error: ' . $e->getMessage());
            return false;
        }
    }
}
