@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
    /* ===== SECTION WRAPPER ===== */
    .section-soft {
        background: #f8f9fc;
        padding: 80px 0;
    }

    /* ===== CARD CLEAN ===== */
    .clean-card {
        border: none;
        border-radius: 18px;
        padding: 18px;
        background: #fff;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        transition: all .3s ease;
    }

    .clean-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    /* ===== ICON STYLE ===== */
    .icon-soft {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        background: rgba(111,66,193,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6f42c1;
        font-size: 20px;
    }

    /* ===== ABOUT IMAGE ===== */
    .about-img-card img {
        border-radius: 20px;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ===== DOCTOR CARD ===== */
    .doctor-card {
        border: none;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 25px rgba(0,0,0,.05);
        transition: all .3s ease;
    }

    .doctor-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,.08);
    }

    .doctor-card img {
        width: 100%;
        aspect-ratio: 4 / 4;
        object-fit: cover;
    }

    .doctor-info {
        padding: 20px;
    }

    /* ===== TEXT ===== */
    .text-purple {
        color: #6f42c1;
    }

    .section-title {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 15px;
    }

    /* Hero Buttons */
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
    <section class="section-soft">
        <div class="container">
            <div class="row align-items-stretch g-5">

                <!-- TEXT -->
                <div class="col-lg-6">
                    <h2 class="section-title text-purple">
                        Mengapa Memilih DV Pets?
                    </h2>
                    <p class="section-subtitle mb-4">
                        Kami menghadirkan layanan kesehatan hewan yang profesional, nyaman, dan terpercaya.
                    </p>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="clean-card d-flex gap-3">
                                <div class="icon-soft">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">Dokter Profesional</h6>
                                    <small class="text-muted">Berpengalaman & bersertifikat</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="clean-card d-flex gap-3">
                                <div class="icon-soft">
                                    <i class="fas fa-clinic-medical"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">Fasilitas Modern</h6>
                                    <small class="text-muted">Peralatan lengkap & terbaru</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="clean-card d-flex gap-3">
                                <div class="icon-soft">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">Layanan Cepat</h6>
                                    <small class="text-muted">Responsif & efisien</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="clean-card d-flex gap-3">
                                <div class="icon-soft">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">Harga Transparan</h6>
                                    <small class="text-muted">Tanpa biaya tersembunyi</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('/about') }}" 
                        class="btn bg-white text-purple mt-4 px-4 py-2 rounded-pill shadow-sm border-0">
                        Selengkapnya →
                    </a>
                </div>

                <!-- IMAGE -->
                <div class="col-lg-6">
                    <div class="about-img-card">
                        <img src="/image/thumbnails/kucing.jpg" alt="Klinik Hewan">
                    </div>
                </div>

            </div>
        </div>
    </section>
    
    <!-- Daftar Dokter -->
    <section class="py-5">
        <div class="container text-center">

            <h2 class="section-title text-purple">Tim Dokter Kami</h2>
            <p class="section-subtitle mb-5">
                Profesional yang siap merawat hewan kesayangan Anda
            </p>

            <div class="row g-4 justify-content-center">
                @forelse($doctors as $doctor)
                <div class="col-md-4 col-sm-6">
                    <div class="doctor-card h-100">

                        @if($doctor->photo)
                            <img src="{{ asset('storage/' . $doctor->photo) }}"
                                alt="{{ $doctor->name }}"
                                onerror="this.onerror=null; this.src='{{ asset('image/default-doctor.jpg') }}'">
                        @else
                            <img src="{{ asset('image/default-doctor.jpg') }}"
                                alt="{{ $doctor->name }}">
                        @endif

                        <div class="doctor-info text-start">
                            <h6 class="fw-bold mb-1">{{ $doctor->name }}</h6>

                            @if($doctor->specialization)
                                <small class="text-purple d-block mb-1">
                                    {{ $doctor->specialization }}
                                </small>
                            @endif

                            <small class="text-muted d-block mb-2">
                                {{ $doctor->schedule }}
                            </small>

                            @if($doctor->description)
                                <p class="small text-muted mb-0">
                                    {{ Str::limit($doctor->description, 80) }}
                                </p>
                            @endif
                        </div>

                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted">Data dokter belum tersedia.</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>

@endsection