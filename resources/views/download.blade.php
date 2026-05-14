@extends('layouts.app')

@section('title', 'Download Aplikasi')

@section('content')
<div class="download-page">
    <!-- Hero Section -->
    <section class="hero-download">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Side - Content -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="hero-content">
                        <div class="badge-new">
                            <i class="fas fa-mobile-alt"></i>
                            <span>Aplikasi Mobile</span>
                        </div>
                        <h1 class="hero-title">Download Aplikasi DV Pets</h1>
                        <p class="hero-desc">Kelola kesehatan hewan peliharaan dengan lebih mudah melalui smartphone Anda</p>
                        
                        <!-- Features -->
                        <div class="features-quick">
                            <div class="feature-quick-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Booking Online</span>
                            </div>
                            <div class="feature-quick-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Konsultasi Dokter</span>
                            </div>
                            <div class="feature-quick-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Rekam Medis</span>
                            </div>
                            <div class="feature-quick-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Reminder Vaksin</span>
                            </div>
                        </div>

                        <!-- Download Button -->
                        <div class="download-cta">
                            <a href="{{ $downloadLink }}" class="btn-download-hero" download>
                                <i class="fab fa-android"></i>
                                <div>
                                    <small>Download untuk</small>
                                    <strong>Android</strong>
                                </div>
                            </a>
                            <p class="download-note-hero">
                                <i class="fas fa-info-circle"></i>
                                File ZIP • Extract terlebih dahulu
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Image -->
                <div class="col-lg-6">
                    <div class="hero-image-wrapper">
                        <div class="hero-image">
                            <img src="/image/doctor-app.png" alt="DV Pets App" class="img-fluid">
                        </div>
                        <!-- Floating Elements -->
                        <div class="floating-element element-1">
                            <i class="fas fa-paw"></i>
                        </div>
                        <div class="floating-element element-2">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="floating-element element-3">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Store Section -->
    <section class="store-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="store-header">
                        <h3>Atau download dari</h3>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="https://play.google.com/store/apps" target="_blank" class="store-card disabled">
                                <div class="store-icon">
                                    <i class="fab fa-google-play"></i>
                                </div>
                                <div class="store-info">
                                    <small>Download di</small>
                                    <strong>Google Play Store</strong>
                                </div>
                                <span class="badge-coming">Segera</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="https://apps.apple.com" target="_blank" class="store-card disabled">
                                <div class="store-icon">
                                    <i class="fab fa-apple"></i>
                                </div>
                                <div class="store-info">
                                    <small>Download di</small>
                                    <strong>Apple App Store</strong>
                                </div>
                                <span class="badge-coming">Segera</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Detail -->
    <section class="features-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="section-title">Fitur Unggulan</h2>
                    <div class="row g-4">
                        <div class="col-md-3 col-6">
                            <div class="feature-box">
                                <div class="feature-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <h5>Booking</h5>
                                <p>Reservasi layanan tanpa antri</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="feature-box">
                                <div class="feature-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <h5>Konsultasi</h5>
                                <p>Chat dengan dokter hewan</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="feature-box">
                                <div class="feature-icon">
                                    <i class="fas fa-file-medical"></i>
                                </div>
                                <h5>Rekam Medis</h5>
                                <p>Riwayat kesehatan digital</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="feature-box">
                                <div class="feature-icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <h5>Notifikasi</h5>
                                <p>Reminder jadwal vaksin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Installation Steps -->
    <section class="installation-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="section-title">Cara Install</h2>
                    <div class="steps-grid">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <h4>Download & Extract</h4>
                            <p>Download file ZIP, lalu extract untuk mendapatkan file APK</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <h4>Izinkan Instalasi</h4>
                            <p>Aktifkan "Install from Unknown Sources" di Settings</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <h4>Install APK</h4>
                            <p>Tap file APK dan ikuti instruksi instalasi</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">4</div>
                            <h4>Selesai</h4>
                            <p>Login atau daftar untuk mulai menggunakan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="section-title">Pertanyaan Umum</h2>
                    <div class="faq-grid">
                        <div class="faq-card">
                            <div class="faq-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <h5>Apakah aplikasi ini gratis?</h5>
                            <p>Ya, aplikasi gratis untuk diunduh. Anda hanya membayar untuk layanan yang dipesan.</p>
                        </div>
                        <div class="faq-card">
                            <div class="faq-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <h5>Kenapa harus extract ZIP?</h5>
                            <p>File dalam format ZIP untuk mempercepat download. Extract menggunakan file manager.</p>
                        </div>
                        <div class="faq-card">
                            <div class="faq-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <h5>Apakah aman install APK?</h5>
                            <p>Ya, APK aman. Pastikan download dari website resmi kami.</p>
                        </div>
                        <div class="faq-card">
                            <div class="faq-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <h5>Bagaimana cara update?</h5>
                            <p>Download versi terbaru dan install ulang. Data tetap tersimpan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .download-page {
        padding-top: 80px;
        background: #f8f9fa;
    }

    /* Hero Section */
    .hero-download {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        padding-right: 20px;
    }

    .badge-new {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #7c3aed;
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 20px;
        animation: fadeInUp 0.6s ease;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 20px;
        line-height: 1.2;
        animation: fadeInUp 0.6s ease 0.1s backwards;
    }

    .hero-desc {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
        animation: fadeInUp 0.6s ease 0.2s backwards;
    }

    /* Features Quick */
    .features-quick {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 40px;
        animation: fadeInUp 0.6s ease 0.3s backwards;
    }

    .feature-quick-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #333;
        font-weight: 500;
    }

    .feature-quick-item i {
        color: #10b981;
        font-size: 1.2rem;
    }

    /* Download CTA */
    .download-cta {
        animation: fadeInUp 0.6s ease 0.4s backwards;
    }

    .btn-download-hero {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        background: #7c3aed;
        color: white;
        padding: 18px 35px;
        border-radius: 15px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
    }

    .btn-download-hero:hover {
        background: #6d28d9;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
        color: white;
    }

    .btn-download-hero i {
        font-size: 2rem;
    }

    .btn-download-hero small {
        display: block;
        font-size: 0.75rem;
        opacity: 0.9;
    }

    .btn-download-hero strong {
        display: block;
        font-size: 1.1rem;
    }

    .download-note-hero {
        margin-top: 15px;
        color: #666;
        font-size: 0.9rem;
    }

    .download-note-hero i {
        color: #7c3aed;
    }

    /* Hero Image */
    .hero-image-wrapper {
        position: relative;
        animation: fadeInRight 0.8s ease;
    }

    .hero-image {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .hero-image img {
        max-width: 100%;
        height: auto;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.15));
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Floating Elements */
    .floating-element {
        position: absolute;
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        animation: floatElement 4s ease-in-out infinite;
    }

    .element-1 {
        top: 10%;
        right: 10%;
        color: #7c3aed;
        animation-delay: 0s;
    }

    .element-2 {
        bottom: 20%;
        left: 5%;
        color: #ef4444;
        animation-delay: 1s;
    }

    .element-3 {
        top: 50%;
        right: 5%;
        color: #fbbf24;
        animation-delay: 2s;
    }

    @keyframes floatElement {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(10deg); }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Store Section */
    .store-section {
        padding: 60px 0;
        background: white;
    }

    .store-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .store-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    .store-card {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #f8f9fa;
        padding: 25px;
        border-radius: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .store-card:hover:not(.disabled) {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .store-card.disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .store-icon {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #7c3aed;
        flex-shrink: 0;
    }

    .store-info {
        flex: 1;
    }

    .store-info small {
        display: block;
        font-size: 0.8rem;
        color: #999;
    }

    .store-info strong {
        display: block;
        font-size: 1.1rem;
        color: #1a1a1a;
        font-weight: 700;
    }

    .badge-coming {
        background: #fbbf24;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Features Section */
    .features-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        text-align: center;
        margin-bottom: 50px;
    }

    .feature-box {
        text-align: center;
        padding: 30px 20px;
        background: white;
        border-radius: 15px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .feature-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        background: #7c3aed;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 1.8rem;
        color: white;
    }

    .feature-box h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .feature-box p {
        color: #666;
        font-size: 0.9rem;
        margin: 0;
    }

    /* Installation Section */
    .installation-section {
        padding: 60px 0;
        background: white;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    .step-card {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .step-number {
        width: 60px;
        height: 60px;
        background: #7c3aed;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 auto 20px;
    }

    .step-card h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .step-card p {
        color: #666;
        margin: 0;
        line-height: 1.6;
    }

    /* FAQ Section */
    .faq-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .faq-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }

    .faq-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .faq-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .faq-icon {
        width: 50px;
        height: 50px;
        background: #7c3aed;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 1.5rem;
        color: white;
    }

    .faq-card h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .faq-card p {
        color: #666;
        margin: 0;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.2rem;
        }

        .hero-desc {
            font-size: 1.1rem;
        }

        .floating-element {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
    }

    @media (max-width: 768px) {
        .hero-download {
            padding: 50px 0;
        }

        .hero-content {
            padding-right: 0;
            text-align: center;
        }

        .hero-title {
            font-size: 1.8rem;
        }

        .hero-desc {
            font-size: 1rem;
        }

        .features-quick {
            grid-template-columns: 1fr;
        }

        .btn-download-hero {
            width: 100%;
            justify-content: center;
        }

        .hero-image img {
            max-width: 80%;
        }

        .floating-element {
            display: none;
        }

        .section-title {
            font-size: 1.6rem;
        }

        .steps-grid {
            grid-template-columns: 1fr;
        }

        .faq-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
