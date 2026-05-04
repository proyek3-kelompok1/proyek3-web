<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'status',
    ];

    protected $appends = ['unread_count', 'last_message_status', 'is_online'];

    public function getIsOnlineAttribute()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) return false;

        if ($user->role === 'doctor') {
            // Check if patient is online
            return $this->user->is_online;
        } else {
            // Check if doctor (user) is online
            return $this->doctor->user->is_online;
        }
    }

    public function getLastMessageStatusAttribute()
    {
        $last = $this->lastMessage;
        if (!$last) return null;

        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) return null;

        $myType = $user->role === 'doctor' ? 'doctor' : 'user';
        
        // Only show read receipts (ticks) if the current user sent the last message
        if ($last->sender_type !== $myType) {
            return null;
        }

        return $last->is_read ? 'read' : 'sent';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function messages()
    {
        return $this->hasMany(ConsultationMessage::class, 'session_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(ConsultationMessage::class, 'session_id')->latest();
    }


    public function getUnreadCountAttribute()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) return 0;
        
        // If I am doctor, I want to see unread messages from 'user'
        // If I am user, I want to see unread messages from 'doctor'
        $otherType = ($user->role === 'doctor') ? 'user' : 'doctor';
        
        return $this->messages()
            ->where('sender_type', $otherType)
            ->where('is_read', false)
            ->count();
    }
}
