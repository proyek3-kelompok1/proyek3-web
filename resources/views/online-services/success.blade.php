@extends('layouts.app')

@section('title', 'Pemesanan Berhasil - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow text-center">
                <div class="card-body p-5">
                    <!-- Icon Success -->
                    <div class="text-success mb-4">
                        <i class="fas fa-check-circle fa-5x"></i>
                    </div>
                    
                    <!-- Title -->
                    <h2 class="text-purple mb-3">Pemesanan Layanan Berhasil!</h2>
                    
                    <!-- Message -->
                    <p class="lead mb-4">
                        Terima kasih telah memesan layanan di DV Pets Clinic. Kami akan mengkonfirmasi pemesanan Anda melalui email atau telepon.
                    </p>

                    @if(session('booking') && session('service'))
                        @php
                            $booking = session('booking');
                            $service = session('service');
                        @endphp
                        
                        <!-- Booking Details Card -->
                        <div class="card border-success mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Detail Pemesanan</h5>
                            </div>
                            <div class="card-body text-start">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Kode Booking:</strong></p>
                                        <h4 class="text-success mb-3"><code>{{ $booking->booking_code }}</code></h4>
                                        
                                        <p class="mb-2"><strong>Nomor Antrian:</strong></p>
                                        <h1 class="text-success mb-4">A{{ str_pad($booking->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</h1>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Layanan:</strong> {{ $service->name }}</p>
                                        <p class="mb-1"><strong>Dokter:</strong> 
                                            @php
                                                // Cari dokter berdasarkan ID
                                                $doctor = \App\Models\Doctor::find($booking->doctor);
                                            @endphp
                                            @if($doctor)
                                                {{ $doctor->name }} @if($doctor->specialization) - {{ $doctor->specialization }} @endif
                                            @else
                                                Dokter tidak ditemukan
                                            @endif
                                        </p>
                                        <p class="mb-1"><strong>Tanggal:</strong> {{ date('d F Y', strtotime($booking->booking_date)) }}</p>
                                        <p class="mb-1"><strong>Waktu:</strong> {{ $booking->booking_time }}</p>
                                        <p class="mb-0"><strong>Hewan:</strong> {{ $booking->nama_hewan }} ({{ $booking->jenis_hewan }})</p>
                                    </div>
                                </div>
                                
                                @if($service->price)
                                <div class="alert alert-info mt-3 mb-0">
                                    <h6 class="alert-heading"><i class="fas fa-money-bill-wave me-2"></i>Informasi Pembayaran</h6>
                                    <p class="mb-0">Total biaya: <strong class="fs-5">Rp {{ number_format($service->price, 0, ',', '.') }}</strong></p>
                                    <small class="text-muted">Pembayaran dapat dilakukan di klinik sebelum pelayanan</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Important Information -->
                    <div class="alert alert-warning text-start">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Informasi Penting</h6>
                        <ul class="mb-0">
                            <li>Datang <strong>15-30 menit lebih awal</strong> sebelum jadwal Anda</li>
                            <li>Tunjukkan <strong>nomor antrian dan kode booking</strong> di resepsionis</li>
                            <li>Bawa hewan dalam kondisi terkontrol (gunakan carrier atau tali)</li>
                            <li>Bawa catatan medis hewan jika ada</li>
                            <li>Hubungi klinik jika perlu membatalkan atau mereschedule</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
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
</style>
@endsection
