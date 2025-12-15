<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // TAMBAHKIN INI - Tentukan nama tabel secara eksplisit
    protected $table = 'feedbacks';

    protected $fillable = [
        'name', 
        'rating', 
        'message',
        'service_type',
        'transaction_id',
        'source',
        'is_verified',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_verified' => 'boolean'
    ];

    // Scope untuk feedback yang sudah diverifikasi
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Scope untuk feedback dari after service
    public function scopeFromAfterService($query)
    {
        return $query->where('source', 'after_service');
    }

    // Scope untuk feedback dari consultation page
    public function scopeFromConsultation($query)
    {
        return $query->where('source', 'consultation');
    }

    // Format tanggal
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }
}