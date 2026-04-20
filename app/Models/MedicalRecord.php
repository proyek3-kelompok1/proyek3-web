<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_rekam_medis',
        'service_booking_id',
        'nama_pemilik',
        'nama_hewan',
        'jenis_hewan',
        'ras',
        'umur',
        'berat_badan',
        'suhu_tubuh',
        'keluhan_utama',
        'diagnosa',
        'tindakan',
        'resep_obat',
        'catatan_dokter',
        'dokter',
        'tanggal_pemeriksaan',
        'kunjungan_berikutnya',
        'status',
        'alamat',
        'telepon',
        'ciri_warna',
        'jenis_kelamin',
        'prognosa'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'kunjungan_berikutnya' => 'date',
    ];

    public function serviceBooking()
    {
        return $this->belongsTo(ServiceBooking::class);
    }

    public function vaccinations()
    {
        return $this->hasMany(VaccinationRecord::class);
    }
}