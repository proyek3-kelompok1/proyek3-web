<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'name', 
        'rating', 
        'message',
        'source',
        'consultation_id',
        'service_type',
        'transaction_id',
        'is_verified'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified' => 'boolean'
    ];

    protected $attributes = [
        'is_verified' => true,
        'source' => 'consultation'
    ];

    // Relasi ke consultation (feedback bisa terkait dengan konsultasi)
    public function consultation()
    {
        return $this->belongsTo(Consultations::class, 'consultation_id');
    }

    // Scope: Feedback yang sudah diverifikasi
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Scope: Feedback dari consultation page
    public function scopeFromConsultation($query)
    {
        return $query->where('source', 'consultation');
    }

    // Scope: Feedback dari after service
    public function scopeFromAfterService($query)
    {
        return $query->where('source', 'after_service');
    }

    // Helper: Bintang rating
    public function getRatingStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '★' : '☆';
        }
        return $stars;
    }

    // Helper: Label sumber
    public function getSourceLabelAttribute()
    {
        return $this->source === 'after_service' ? 'Dari Layanan' : 'Dari Konsultasi';
    }

    // Helper: Format tanggal
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y, H:i');
    }

    // ============== TAMBAHAN BARU ==============
    // Attribute untuk menampilkan apakah ini consultation murni
    public function getIsPureConsultationAttribute()
    {
        return is_null($this->rating) && $this->source === 'consultation';
    }

    // Attribute untuk tipe pesan
    public function getMessageTypeAttribute()
    {
        if ($this->is_pure_consultation) {
            return 'konsultasi';
        } elseif ($this->source === 'consultation' && !is_null($this->rating)) {
            return 'feedback_konsultasi';
        } elseif ($this->source === 'after_service') {
            return 'feedback_layanan';
        }
        return 'lainnya';
    }

    // Attribute untuk label tipe pesan
    public function getMessageTypeLabelAttribute()
    {
        $labels = [
            'konsultasi' => 'Konsultasi',
            'feedback_konsultasi' => 'Feedback Konsultasi',
            'feedback_layanan' => 'Feedback Layanan',
            'lainnya' => 'Lainnya'
        ];
        return $labels[$this->message_type] ?? $this->message_type;
    }

    // Attribute untuk badge warna berdasarkan tipe
    public function getMessageTypeBadgeAttribute()
    {
        $badges = [
            'konsultasi' => '<span class="badge bg-primary">Konsultasi</span>',
            'feedback_konsultasi' => '<span class="badge bg-info">Feedback Konsultasi</span>',
            'feedback_layanan' => '<span class="badge bg-success">Feedback Layanan</span>',
            'lainnya' => '<span class="badge bg-secondary">Lainnya</span>'
        ];
        return $badges[$this->message_type] ?? '';
    }
}