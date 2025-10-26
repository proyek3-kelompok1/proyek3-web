@extends('layouts.app')

@section('title', 'Pemesanan Berhasil - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow text-center">
                <div class="card-body p-5">
                    <div class="text-success mb-4">
                        <i class="fas fa-calendar-check fa-5x"></i>
                    </div>
                    
                    <h2 class="text-purple mb-3">Pemesanan Layanan Berhasil!</h2>
                    
                    <p class="lead mb-4">
                        Terima kasih telah memesan layanan di DV Pets Clinic. Detail pemesanan Anda telah dikirim ke email.
                    </p>

                    @if(session('booking'))
                    @php
                        $booking = session('booking');
                        // Format nama layanan
                        $serviceNames = [
                            'vaksinasi' => 'Vaksinasi',
                            'konsultasi_umum' => 'Konsultasi Umum',
                            'grooming' => 'Grooming',
                            'perawatan_gigi' => 'Perawatan Gigi',
                            'pemeriksaan_darah' => 'Pemeriksaan Darah',
                            'sterilisasi' => 'Sterilisasi'
                        ];
                        
                        $doctorNames = [
                            'drh_andi' => 'drh. Andi Wijaya - Spesialis Umum',
                            'drh_sari' => 'drh. Sari Dewi - Spesialis Bedah',
                            'drh_budi' => 'drh. Budi Santoso - Spesialis Dermatologi',
                            'drh_maya' => 'drh. Maya Purnama - Spesialis Gigi'
                        ];
                    @endphp
                    
                    <!-- Kartu Nomor Antrian -->
                    <div class="card border-success mb-4">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>Nomor Antrian Anda</h4>
                        </div>
                        <div class="card-body">
                            <div class="display-1 fw-bold text-success mb-2">
                                A{{ str_pad($booking->nomor_antrian, 3, '0', STR_PAD_LEFT) }}
                            </div>
                            <p class="text-muted mb-0">Simpan nomor ini untuk menunjukkan di klinik</p>
                        </div>
                    </div>

                    <div class="alert alert-info text-start">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Detail Pemesanan:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Kode Booking:</strong> 
                                    <span class="badge bg-purple">{{ $booking->booking_code }}</span>
                                </p>
                                <p class="mb-2"><strong>Layanan:</strong> {{ $serviceNames[$booking->service_type] ?? $booking->service_type }}</p>
                                <p class="mb-2"><strong>Dokter:</strong> {{ $doctorNames[$booking->doctor] ?? $booking->doctor }}</p>
                                <p class="mb-2"><strong>Nomor Antrian:</strong> 
                                    <span class="badge bg-success fs-6">A{{ str_pad($booking->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</p>
                                <p class="mb-2"><strong>Waktu:</strong> {{ $booking->booking_time }}</p>
                                <p class="mb-2"><strong>Hewan:</strong> {{ $booking->nama_hewan }}</p>
                                <p class="mb-0"><strong>Jenis:</strong> {{ $booking->jenis_hewan }} - {{ $booking->ras }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Informasi Antrian -->
                    <div class="alert alert-warning text-start">
                        <h6 class="alert-heading"><i class="fas fa-clock me-2"></i>Informasi Antrian:</h6>
                        <ul class="mb-0">
                            <li><strong>Datang 15-30 menit lebih awal</strong> sebelum jadwal Anda</li>
                            <li>Tunjukkan <strong>nomor antrian dan kode booking</strong> di resepsionis</li>
                            <li>Estimasi waktu tunggu: <strong>30-45 menit</strong> tergantung antrian</li>
                            <li>Bawa hewan dalam kondisi terkontrol (gunakan carrier atau tali)</li>
                            <li>Hubungi klinik jika perlu membatalkan atau mereschedule</li>
                        </ul>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <a href="{{ url('/') }}" class="btn btn-purple me-md-2">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                        <a href="{{ route('online-services.queue') }}" class="btn btn-info me-md-2">
                            <i class="fas fa-list-ol me-2"></i>Lihat Antrian
                        </a>
                        <a href="{{ route('online-services.index') }}" class="btn btn-outline-purple">
                            <i class="fas fa-plus me-2"></i>Pesan Layanan Lain
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-success">
                            <i class="fas fa-print me-2"></i>Cetak Tiket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-purple {
    background-color: #6f42c1;
}
.text-purple {
    color: #6f42c1;
}
.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: white;
}
.btn-purple:hover {
    background-color: #5a32a3;
    border-color: #5a32a3;
    color: white;
}
.btn-outline-purple {
    border-color: #6f42c1;
    color: #6f42c1;
}
.btn-outline-purple:hover {
    background-color: #6f42c1;
    color: white;
}

/* Style untuk print */
@media print {
    .btn {
        display: none !important;
    }
}
</style>
@endsection