<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
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
        'dokter',
        'layanan',
        'tanggal_jam',
        'keluhan',
        'status'
    ];

    protected $casts = [
        'tanggal_jam' => 'datetime',
    ];
}