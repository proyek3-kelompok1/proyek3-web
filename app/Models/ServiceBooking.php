<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pemilik',
        'email',
        'telepon',
        'nama_hewan',
        'jenis_hewan',
        'ras',
        'umur',
        'service_type',
        'doctor',
        'booking_date',
        'booking_time',
        'catatan',
        'status',
        'booking_code'
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];
}