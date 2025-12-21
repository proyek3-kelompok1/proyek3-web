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
        'service_id',
        'doctor',
        'booking_date',
        'booking_time',
        'catatan',
        'status',
        'booking_code',
        'nomor_antrian',
        'total_price'
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    /**
     * Relasi ke Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Relasi ke Dokter
     */
    public function doctorInfo()
    {
        return $this->belongsTo(Doctor::class, 'doctor');
    }

    /**
     * Relasi ke Rekam Medis
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'service_booking_id');
    }

    /**
     * Scope untuk antrian hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('booking_date', now()->format('Y-m-d'));
    }

    /**
     * Scope untuk antrian aktif
     */
    public function scopeActiveQueue($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    /**
     * Cek apakah sudah ada rekam medis
     */
    public function hasMedicalRecord()
    {
        return $this->medicalRecords()->exists();
    }

    /**
     * Get nama layanan lengkap
     */
    public function getServiceNameAttribute()
    {
        $serviceNames = [
            'vaksinasi' => 'Vaksinasi',
            'konsultasi_umum' => 'Konsultasi Umum',
            'grooming' => 'Grooming',
            'perawatan_gigi' => 'Perawatan Gigi',
            'pemeriksaan_darah' => 'Pemeriksaan Darah',
            'sterilisasi' => 'Sterilisasi',
            'general' => 'Konsultasi Umum',
            'vaccination' => 'Vaksinasi',
            'surgery' => 'Operasi',
            'dental' => 'Perawatan Gigi',
            'laboratory' => 'Laboratorium',
            'inpatient' => 'Rawat Inap',
            'emergency' => 'Darurat'
        ];

        return $serviceNames[$this->service_type] ?? $this->service_type;
    }

    /**
     * Get nama dokter lengkap
     */
    public function getDoctorNameAttribute()
    {
        $doctor = Doctor::find($this->doctor);
        return $doctor ? $doctor->name . ($doctor->specialization ? ' - ' . $doctor->specialization : '') : $this->doctor;
    }

    /**
     * Get posisi antrian
     */
    public function getQueuePositionAttribute()
    {
        $queueToday = ServiceBooking::whereDate('booking_date', $this->booking_date)
            ->where('service_type', $this->service_type)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('nomor_antrian')
            ->get();

        $position = $queueToday->search(function($booking) {
            return $booking->id === $this->id;
        });

        return $position !== false ? $position + 1 : null;
    }

    /**
     * Get antrian yang sedang dilayani untuk service type yang sama
     */
    public function getCurrentServingAttribute()
    {
        return ServiceBooking::whereDate('booking_date', $this->booking_date)
            ->where('service_type', $this->service_type)
            ->where('status', 'confirmed')
            ->orderBy('nomor_antrian')
            ->first();
    }

    /**
     * Get jumlah antrian sebelum ini
     */
    public function getWaitingBeforeAttribute()
    {
        return ServiceBooking::whereDate('booking_date', $this->booking_date)
            ->where('service_type', $this->service_type)
            ->where('status', 'pending')
            ->where('nomor_antrian', '<', $this->nomor_antrian)
            ->count();
    }

    /**
     * Get estimasi waktu tunggu (menit)
     */
    public function getEstimatedWaitMinutesAttribute()
    {
        return $this->waiting_before * 15; // 15 menit per antrian
    }
}