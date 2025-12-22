@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
    /* ===== ABOUT / WHY CHOOSE US ===== */
.about-why {
    background: linear-gradient(135deg, #f9f6ff, #ffffff);
    padding: 80px 0;
}

.about-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
}

.about-card ul li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.about-card i {
    background: rgba(111,66,193,.1);
    padding: 8px;
    border-radius: 50%;
    font-size: 14px;
}

.about-image {
    position: relative;
}

.about-image img {
    border-radius: 30px;
    box-shadow: 0 30px 60px rgba(0,0,0,.2);
}

.about-image::before {
    content: '';
    position: absolute;
    top: -20px;
    left: -20px;
    width: 100%;
    height: 100%;
    border-radius: 30px;
    background: linear-gradient(135deg, #6f42c1, #9b6dff);
    z-index: -1;
}

.hero-section {
    /* background: linear-gradient(135deg, #6f42c1, #9b6dff); */
    color: #fff;
    padding: 120px 0;
    position: relative;
    overflow: hidden;
}

.hero-section::after {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,.15);
    border-radius: 50%;
}

.btn-container a {
    backdrop-filter: blur(5px);
    background: rgba(255,255,255,.15);
}

/* ===== SERVICE CARD ===== */
.service-card {
    border: none;
    border-radius: 20px;
    transition: all .4s ease;
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,.15);
}

/* ===== ABOUT ===== */
.about-section {
    background: linear-gradient(180deg, #faf8ff, #ffffff);
}

/* ===== DOCTOR CARD ===== */
.doctor-card {
    border-radius: 20px;
    overflow: hidden;
    transition: all .4s ease;
    box-shadow: 0 15px 30px rgba(0,0,0,.1);
}

.doctor-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 60px rgba(0,0,0,.2);
}

.doctor-card img {
    transition: transform .4s ease;
}

.doctor-card:hover img {
    transform: scale(1.05);
}

/* ===== SECTION TITLE ===== */
.text-purple {
    color: #6f42c1 !important;
}
.btn-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}

.btn-container a {
    padding: 12px 25px;
    border-radius: 10px;
    border: 2px solid #fff;
    color: #fff;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-container a:hover {
    background-color: #fff;
    color: #6f42c1; /* ungu lembut biar serasi */
    transform: scale(1.05);
}
</style>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            {{-- Jika user sudah login, tampilkan nama --}}
            @auth
                <h2 class="text-light mb-3">Selamat datang, {{ Auth::user()->name }}! 🐾</h2>
            @endauth

            <h1 class="display-4 fw-bold mb-4">Perawatan Terbaik untuk Sahabat Setia Anda</h1>
            <p class="lead mb-5">Klinik hewan terpercaya dengan pelayanan profesional dan penuh kasih sayang</p>
            <div class="btn-container">
            <a href="{{ url('/services') }}" class="btn btn-outline-light btn-lg px-4">Lihat Layanan</a>
            <a href="{{ route('online-services.index') }}" class="btn btn-outline-light btn-lg px-4">Pemesanan Layanan Online</a>
            <a href="{{ route('medical-records.index') }}" class="btn btn-outline-light btn-lg px-4">Rekam Medis</a>
            <a href="{{ route('online-services.queue') }}" class="btn btn-outline-light btn-lg px-4">Lihat Antrian</a>
            
            </div>
        </div>
    </section>

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
   <section class="about-why">
    <div class="container position-relative">
        <div class="row align-items-center">

            <!-- KIRI: TEKS -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-card">
                    <h2 class="fw-bold text-purple mb-4">
                        Mengapa Memilih Klinik DV Pets?
                    </h2>

                    <p class="mb-4">
                        Kami adalah klinik hewan yang berkomitmen memberikan perawatan terbaik
                        dengan tim dokter hewan berpengalaman dan fasilitas modern.
                    </p>

                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-check text-purple me-2 mt-1"></i>
                            Dokter hewan berpengalaman dan bersertifikat
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-check text-purple me-2 mt-1"></i>
                            Peralatan medis modern dan lengkap
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-check text-purple me-2 mt-1"></i>
                            Layanan 24 jam untuk keadaan darurat
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-check text-purple me-2 mt-1"></i>
                            Harga transparan dan kompetitif
                        </li>
                    </ul>

                    <a href="{{ url('/about') }}" class="btn btn-purple mt-3">
                        Selengkapnya Tentang Kami
                    </a>
                </div>
            </div>

            <!-- KANAN: GAMBAR -->
            <div class="col-lg-6 position-relative">
                <div class="about-image-floating">
                    <img src="/image/thumbnails/kucing.jpg"
                         alt="Dokter Hewan"
                         class="img-fluid">
                </div>
            </div>

        </div>
    </section>
    
    <!-- Daftar Dokter -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold text-purple mb-4">Tim Dokter Kami</h2>
        <p class="text-muted mb-5">Dokter berpengalaman dan penuh kasih dalam merawat hewan kesayangan Anda</p>

        <div class="row g-4 justify-content-center">
            @forelse($doctors as $doctor)
            <div class="col-md-4">
                <div class="card h-100 p-3 text-center">
                    @if($doctor->photo)
                        <img src="{{ asset('storage/' . $doctor->photo) }}"
                             alt="{{ $doctor->name }}"
                             class="img-fluid rounded mb-3"
                             style="height: 400px; width: 100%; object-fit: cover;"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-doctor.jpg') }}'">
                    @else
                        <img src="{{ asset('images/default-doctor.jpg') }}"
                             alt="{{ $doctor->name }}"
                             class="img-fluid rounded mb-3"
                             style="height: 400px; width: 100%; object-fit: cover;">
                    @endif
                    
                    <h5 class="fw-bold text-purple">{{ $doctor->name }}</h5>
                    @if($doctor->specialization)
                        <p class="text-muted mb-1">{{ $doctor->specialization }}</p>
                    @endif
                    <p class="text-muted mb-2">{{ $doctor->schedule }}</p>
                    @if($doctor->description)
                        <p class="small text-muted">{{ Str::limit($doctor->description, 100) }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-muted">Data dokter sedang tidak tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection