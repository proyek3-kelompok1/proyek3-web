<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'nama_vaksin',
        'dosis',
        'tanggal_vaksin',
        'tanggal_booster',
        'dokter',
        'catatan'
    ];

    protected $casts = [
        'tanggal_vaksin' => 'date',
        'tanggal_booster' => 'date',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}