<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AppNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;
    protected $typeKey;
    protected $data;

    public function __construct($title, $body, $typeKey = 'general', $data = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->typeKey = $typeKey;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return array_merge([
            'title' => $this->title,
            'body' => $this->body,
            'type_key' => $this->typeKey,
        ], $this->data);
    }
}
