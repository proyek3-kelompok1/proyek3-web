<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'sender_type',
        'message',
        'is_read',
    ];

    public function session()
    {
        return $this->belongsTo(ConsultationSession::class, 'session_id');
    }
}
