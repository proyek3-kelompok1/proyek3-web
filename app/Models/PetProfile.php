<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'breed',
        'age_months',
        'weight_kg',
        'photo',
        'health_history_notes',
        'needs_vaccine',
        'needs_grooming',
    ];

    protected $appends = ['photo_url', 'age_formatted', 'health_status'];

    protected $casts = [
        'needs_vaccine' => 'boolean',
        'needs_grooming' => 'boolean',
        'weight_kg' => 'float',
        'age_months' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) return null;
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }
        return url('storage/' . $this->photo);
    }

    public function getAgeFormattedAttribute()
    {
        if ($this->age_months === null) return "Umur tidak diketahui";
        if ($this->age_months < 12) {
            return "{$this->age_months} Bulan";
        }
        $years = floor($this->age_months / 12);
        $months = $this->age_months % 12;
        if ($months === 0) {
            return "{$years} Tahun";
        }
        return "{$years} Tahun {$months} Bulan";
    }

    public function getHealthStatusAttribute()
    {
        $issues = [];
        if ($this->needs_vaccine) {
            $issues[] = "Waktunya Vaksinasi";
        }
        if ($this->needs_grooming) {
            $issues[] = "Waktunya Grooming";
        }
        
        if (count($issues) > 0) {
            return "Perlu Perhatian: " . implode(', ', $issues);
        }
        return "Sehat & Normal";
    }
}
