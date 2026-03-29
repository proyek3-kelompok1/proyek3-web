@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')

<section class="py-5 text-center about-hero position-relative">
    <div class="container position-relative">
        <h1 class="fw-semibold mb-3">
            Tentang DV Pets
        </h1>
        <p class="text-muted mb-0">
            Kami berkomitmen memberikan perawatan kesehatan terbaik untuk hewan peliharaan Anda
        </p>
    </div>
</section>

<section class="py-5 my-5">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- TEXT -->
            <div class="col-lg-6">
                <h3 class="fw-semibold mb-4">Tentang Kami</h3>

                <p class="text-muted">
                    Klinik Hewan DV Pets lahir dari kepedulian dan kecintaan kami terhadap 
                    hewan peliharaan yang sudah menjadi bagian dari keluarga.
                </p>

                <p class="text-muted">
                    Kami percaya bahwa setiap hewan berhak mendapatkan perawatan yang aman, nyaman, dan penuh kasih sayang. 
                    Berawal dari keinginan untuk menghadirkan layanan kesehatan hewan yang tidak hanya profesional tetapi juga ramah, 
                    DV Pets hadir sebagai tempat di mana pemilik dan hewan peliharaan merasa didengar dan dihargai.
                </p>

                <p class="text-muted">
                    Dengan dukungan dokter hewan berpengalaman serta fasilitas medis modern, 
                    kami memberikan layanan yang menyeluruh mulai dari pemeriksaan rutin hingga penanganan medis lanjutan 
                    dengan pendekatan yang personal untuk setiap hewan.
                </p>
            </div>

            <!-- IMAGE -->
            <div class="col-lg-6">
                <div class="image-collage">
                    <img src="/image/thumbnails/njing.jpg" class="img-main">
                    <img src="/image/thumbnails/persia.jpg" class="img-small top">
                    <img src="/image/thumbnails/cingg.jpg" class="img-small bottom">
                    <img src="/image/thumbnails/persiaa.jpg" class="img-small right">
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* ===== HERO ===== */
    .about-hero {
        position: relative;
        background: linear-gradient(180deg, #f8f6ff, #ffffff);
        overflow: hidden;
    }

    .about-hero h1 {
        color: #6f42c1;
    }

    /* efek blur background */
    .about-hero::before {
        content: '';
        position: absolute;
        width: 280px;
        height: 280px;
        background: #6f42c1;
        opacity: 0.1;
        filter: blur(100px);
        top: -60px;
        left: 50%;
        transform: translateX(-50%);
    }

    /* ===== TEXT ===== */
    .text-muted {
        line-height: 1.8;
    }

    /* underline */
    h3::after {
        content: '';
        display: block;
        width: 45px;
        height: 3px;
        background: #6f42c1;
        margin-top: 10px;
        border-radius: 10px;
    }

    /* ===== IMAGE ===== */
    .image-collage {
        position: relative;
        height: 400px;
    }

    .img-main {
        width: 70%;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,.15);
        transition: 0.4s ease;
    }

    .img-small {
        position: absolute;
        width: 45%;
        border-radius: 18px;
        box-shadow: 0 15px 30px rgba(0,0,0,.12);
        transition: 0.4s ease;
    }

    /* posisi gambar */
    .img-small.top {
        top: -20px;
        right: 0;
    }

    .img-small.bottom {
        bottom: -20px;
        left: 10%;
    }

    .img-small.right {
        bottom: 20%;
        right: -10px;
    }

    /* hover */
    .image-collage img:hover {
        transform: translateY(-5px) scale(1.03);
    }

    /* ===== ANIMASI ===== */
    .image-collage img {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.8s ease forwards;
    }

    .image-collage img:nth-child(1) { animation-delay: 0.2s; }
    .image-collage img:nth-child(2) { animation-delay: 0.4s; }
    .image-collage img:nth-child(3) { animation-delay: 0.6s; }
    .image-collage img:nth-child(4) { animation-delay: 0.8s; }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {

        .image-collage {
            position: static;
            height: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .image-collage img {
            position: static !important;
            width: 100%;
            opacity: 1 !important;
            transform: none !important;
            animation: none !important;
            border-radius: 14px;
        }

        .img-main,
        .img-small {
            width: 100%;
        }
    }
</style>
@endpush