<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;


class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'type',
        'content',
        'description',
        'thumbnail',
        'video_url',
        'duration',
        'level',
        'reading_time',
        'is_published',
        'view'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = ['thumbnail_url'];

    /**
     * Scope untuk hanya mengambil yang published
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope untuk video
     */
    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    /**
     * Scope untuk guide
     */
    public function scopeGuides($query)
    {
        return $query->where('type', 'guide');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return asset('storage/' . $this->thumbnail);
        }
        
        // Default thumbnail berdasarkan type
        return $this->type == 'video' 
            ? asset('images/default-video.jpg')
            : asset('images/default-guide.jpg');
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'video' => 'fas fa-play-circle',
            'guide' => 'fas fa-book',
            default => 'fas fa-file'
        };
    }

    public function getCategoryColorAttribute()
    {
        return match($this->category) {
            'kesehatan' => 'success',
            'perilaku' => 'info',
            'nutrisi' => 'warning',
            'grooming' => 'primary',
            'training' => 'dark',
            default => 'secondary'
        };
    }

    /**
     * Format created_at untuk tampilan
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->translatedFormat('d F Y');
    }
    
}