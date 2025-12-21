<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'price',
        'duration_minutes',
        'details',
        'service_type',
        'is_active',
        'order'
    ];

    protected $casts = [
        'price' => 'float',
        'duration_minutes' => 'integer',
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Generate slug dari name
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            $service->slug = \Str::slug($service->name);
        });

        static::updating(function ($service) {
            if ($service->isDirty('name')) {
                $service->slug = \Str::slug($service->name);
            }
        });
    }

    /**
     * Scope untuk layanan aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * Get service type label
     */
    public function getServiceTypeLabelAttribute()
    {
        $types = [
            'general' => 'Umum',
            'vaccination' => 'Vaksinasi',
            'surgery' => 'Operasi',
            'grooming' => 'Grooming',
            'dental' => 'Perawatan Gigi',
            'laboratory' => 'Laboratorium',
            'inpatient' => 'Rawat Inap'
        ];

        return $types[$this->service_type] ?? $this->service_type;
    }

    /**
     * Format price
     */
    public function getFormattedPriceAttribute()
    {
        if (!$this->price) {
            return 'Konsultasi';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Format duration
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_minutes) {
            return '-';
        }
        
        if ($this->duration_minutes >= 60) {
            $hours = floor($this->duration_minutes / 60);
            $minutes = $this->duration_minutes % 60;
            
            if ($minutes > 0) {
                return $hours . ' jam ' . $minutes . ' menit';
            }
            return $hours . ' jam';
        }
        
        return $this->duration_minutes . ' menit';
    }
}