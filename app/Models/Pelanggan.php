<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'email', 
        'password',
        'telepon',
        'alamat'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}