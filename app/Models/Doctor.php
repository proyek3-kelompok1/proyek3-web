<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialization',
        'schedule', 
        'photo',
        'description',
    ];

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Pastikan path storage benar
            return asset('storage/' . $this->photo);
        }
        // Fallback ke gambar default
        return asset('images/default-doctor.jpg');
    }
}