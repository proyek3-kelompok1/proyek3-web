@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Perawatan Terbaik untuk Sahabat Setia Anda</h1>
            <p class="lead mb-5">Klinik hewan terpercaya dengan pelayanan profesional dan penuh kasih sayang</p>
            <a href="{{ url('/contact') }}" class="btn btn-light btn-lg px-4 me-3">Buat Janji Temu</a>
            <a href="{{ url('/services') }}" class="btn btn-outline-light btn-lg px-4">Lihat Layanan</a>
        </div>
    </section>

    <!-- Layanan Unggulan -->
    <!-- Layanan Unggulan -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-purple">Layanan Unggulan Kami</h2>
            <p class="text-muted">Berbagai layanan kesehatan hewan dengan standar tertinggi</p>
        </div>
        
        <div class="row g-4">
            <!-- Konsultasi Umum -->
            <div class="col-md-4">
                <div class="card service-card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-stethoscope text-white fs-3"></i>
                        </div>
                        <h5 class="card-title fw-bold text-purple">Konsultasi Umum</h5>
                        <p class="card-text">Pemeriksaan kesehatan rutin dan konsultasi untuk hewan peliharaan Anda.</p>
                    </div>
                </div>
            </div>
            
            <!-- Vaksinasi -->
            <div class="col-md-4">
                <div class="card service-card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-syringe text-white fs-3"></i>
                        </div>
                        <h5 class="card-title fw-bold text-purple">Vaksinasi</h5>
                        <p class="card-text">Program vaksinasi lengkap untuk melindungi hewan dari berbagai penyakit.</p>
                    </div>
                </div>
            </div>
            
            <!-- Perawatan Gigi -->
            <div class="col-md-4">
                <div class="card service-card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-tooth text-white fs-3"></i>
                        </div>
                        <h5 class="card-title fw-bold text-purple">Perawatan Gigi</h5>
                        <p class="card-text">Pembersihan gigi dan perawatan kesehatan mulut untuk hewan kesayangan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Tentang Kami Singkat -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold text-purple mb-4">Mengapa Memilih Klinik DV Pets?</h2>
                    <p class="mb-4">Kami adalah klinik hewan yang berkomitmen memberikan perawatan terbaik dengan tim dokter hewan berpengalaman dan fasilitas modern.</p>
                    
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-check text-purple me-2"></i>
                            Dokter hewan berpengalaman dan bersertifikat
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check text-purple me-2"></i>
                            Peralatan medis modern dan lengkap
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check text-purple me-2"></i>
                            Layanan 24 jam untuk keadaan darurat
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check text-purple me-2"></i>
                            Harga transparan dan kompetitif
                        </li>
                    </ul>
                    
                    <a href="{{ url('/about') }}" class="btn btn-purple mt-3">Selengkapnya Tentang Kami</a>
                </div>
                
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                         alt="Dokter Hewan" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>
@endsection