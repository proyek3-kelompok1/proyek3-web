<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultations extends Model
{
    use HasFactory;

    protected $table = 'consultations';

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'pet_type',
        'services',
        'message'
    ];

    protected $casts = [
        'services' => 'array'
    ];

    // Relasi ke feedback (satu konsultasi bisa punya banyak feedback)
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'consultation_id');
    }

    // Helper: Label jenis hewan
    public function getPetTypeLabelAttribute()
    {
        $labels = [
            'kucing' => 'Kucing',
            'anjing' => 'Anjing',
            'burung' => 'Burung',
            'kelinci' => 'Kelinci',
            'hamster' => 'Hamster',
            'lainnya' => 'Lainnya',
        ];
        return $labels[$this->pet_type] ?? $this->pet_type;
    }

    // Helper: Format tanggal
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y, H:i');
    }
}