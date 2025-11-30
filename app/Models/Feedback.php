<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'rating', 
        'message',
        // 'metadata' // Tambahkan ini
    ];

    // protected $casts = [
    //     'metadata' => 'array' // Cast JSON ke array
    // ];
}