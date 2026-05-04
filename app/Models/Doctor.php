<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name', 
        'email',
        'specialization', 
        'schedule', 
        'photo', 
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk photo_url
    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return asset('images/default-doctor.jpg');
        }
        
        // Cek apakah sudah full URL
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }
        
        // Untuk storage path
        if (strpos($this->photo, 'storage/') === 0) {
            return asset($this->photo);
        }
        
        return asset('storage/' . $this->photo);
    }
}