@extends('layouts.app')

@section('title', 'Tentang Kami')

    @section('content')
        <section class="about-hero text-center d-flex align-items-center">
            <div class="container">
                <h1 class="fw-bold mb-3">Tentang Klinik DV Pets</h1>
                <p class="lead">Kami berkomitmen memberikan perawatan terbaik untuk hewan peliharaan Anda</p>
            </div>
        </section>

        <section class="about-section py-5">
            <div class="container">
                <div class="row align-items-center gy-5">

                    <!-- KIRI -->
                    <div class="col-lg-6">
                        <div class="about-card">
                            <h2 class="mb-4">Tentang Kami</h2>

                            <p>
                                Klinik Hewan DV Pets lahir dari kepedulian dan kecintaan kami terhadap
                                hewan peliharaan yang sudah menjadi bagian dari keluarga.
                            </p>

                            <p>
                                Kami percaya bahwa setiap hewan berhak mendapatkan perawatan yang aman,
                                nyaman, dan penuh kasih sayang. DV Pets hadir sebagai tempat di mana
                                pemilik dan hewan peliharaan merasa didengar dan dihargai.
                            </p>

                            <p>
                                Dengan dukungan dokter hewan berpengalaman serta fasilitas modern,
                                kami memberikan layanan menyeluruh dengan pendekatan personal.
                            </p>
                        </div>
                    </div>

                    <!-- KANAN (GRID GAMBAR) -->
                    <div class="col-lg-6">
                        <div class="about-image-grid">
                            <img src="/image/thumbnails/njing.jpg">
                            <img src="/image/thumbnails/persia.jpg">
                            <img src="/image/thumbnails/cingg.jpg">
                            <img src="/image/thumbnails/persiaa.jpg">
                        </div>
                    </div>

                </div>
            </div>
        </section>

@endsection

@push('styles')
    <style>
        /* FIX NAVBAR OFFSET */
        body {
            padding-top: 80px;
        }

        /* HERO */
        .about-hero {
            height: 25vh;
            background: linear-gradient(135deg, #6a3093, #8a4dcc);
            color: white;
            text-align: center;
        }

        .about-hero h1 {
            font-size: 2.8rem;
        }

        .about-hero p {
            opacity: 0.9;
        }

        /* SECTION */
        .about-section {
            background: linear-gradient(180deg, #f5efff, #ffffff);
        }

        /* CARD */
        .about-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(106, 48, 147, 0.15);
            transition: 0.3s;
        }

        .about-card:hover {
            transform: translateY(-5px);
        }

        /* TITLE */
        .about-card h2 {
            color: #6a3093;
            font-weight: 700;
            position: relative;
        }

        .about-card h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: #8a4dcc;
            margin-top: 10px;
            border-radius: 10px;
        }

        /* TEXT */
        .about-card p {
            color: #555;
            line-height: 1.7;
        }

        /* GRID GAMBAR */
        .about-image-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .about-image-grid img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 15px;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* hover gambar */
        .about-image-grid img:hover {
            transform: scale(1.05);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .about-hero {
                height: 40vh;
            }

            .about-card {
                padding: 25px;
            }
        }
    </style>
@endpush