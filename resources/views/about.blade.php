@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
    <section class="py-5 bg-light about-hero text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fw-bold text-purple mb-4">Tentang Klinik DV Pets</h1>
                    <p class="lead">Kami berkomitmen memberikan perawatan kesehatan terbaik untuk hewan peliharaan Anda</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 about-section">
    <div class="container">
        <div class="row align-items-start gy-5">

            <!-- KIRI: TEKS -->
            <div class="col-lg-6">
                <div class="about-card">

                    <h2 class="fw-bold text-purple mb-3">Tentang Kami</h2>

                    <p class="text-justify mb-4">
                        Klinik Hewan DV Pets lahir dari kepedulian dan kecintaan kami terhadap
                        hewan peliharaan yang sudah menjadi bagian dari keluarga.
                    </p>

                    <p class="text-justify mb-4">
                        Kami percaya bahwa setiap hewan berhak mendapatkan perawatan yang aman,
                        nyaman, dan penuh kasih sayang. Berawal dari keinginan untuk menghadirkan
                        layanan kesehatan hewan yang tidak hanya profesional tetapi juga ramah,
                        DV Pets hadir sebagai tempat di mana pemilik dan hewan peliharaan merasa
                        didengar dan dihargai.
                    </p>

                    <p class="text-justify mb-5">
                        Dengan dukungan dokter hewan berpengalaman serta fasilitas medis modern,
                        kami memberikan layanan yang menyeluruh mulai dari pemeriksaan rutin
                        hingga penanganan medis lanjutan dengan pendekatan yang personal untuk
                        setiap hewan.
                    </p>
                </div>
            </div>

            <!-- KANAN: GAMBAR -->
            <!-- KANAN: KOLESA GAMBAR -->
<div class="col-lg-6">
    <div class="about-image-collage">
        <img src="/image/thumbnails/njing.jpg" alt="Hewan 1">
        <img src="/image/thumbnails/persia.jpg" alt="Hewan 2">
        <img src="/image/thumbnails/cingg.jpg" alt="Hewan 3">
        <img src="/image/thumbnails/persiaa.jpg" alt="Hewan 4">
    </div>
</div>


            </div>
        </div>
    </section>

@endsection

@push('styles')
<style>
/* ===== HERO ABOUT ===== */
.about-hero {
    background: linear-gradient(135deg, #6f42c1, #9b6dff);
    color: white;
}

.about-hero p {
    color: rgba(255,255,255,.9);
}

/* ===== ABOUT CONTENT ===== */
.about-section {
    background: linear-gradient(180deg, #f9f6ff, #ffffff);
}

.about-card {
    background: #ffffff;
    padding: 50px;
    border-radius: 24px;
    box-shadow: 0 25px 50px rgba(0,0,0,.08);
}

.about-card h2,
.about-card h5 {
    position: relative;
}

.about-card h2::after {
    content: '';
    display: block;
    width: 60px;
    height: 4px;
    background: #6f42c1;
    border-radius: 10px;
    margin-top: 10px;
}

/* ===== LIST MISI ===== */
.about-card ul {
    padding-left: 0;
}

.about-card ul li {
    list-style: none;
    padding-left: 30px;
    position: relative;
}

.about-card ul li::before {
    content: "✔";
    position: absolute;
    left: 0;
    color: #6f42c1;
    font-weight: bold;
}

/* ===== IMAGE STYLE ===== */
.about-image-wrapper {
    position: relative;
}

.about-image-wrapper img {
    border-radius: 30px;
    box-shadow: 0 30px 60px rgba(0,0,0,.2);
}

.about-image-wrapper::before {
    content: '';
    position: absolute;
    top: -20px;
    left: -20px;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #6f42c1, #9b6dff);
    border-radius: 30px;
    z-index: -1;
}

/* ===== TEXT ===== */
.text-justify {
    text-align: justify;
    text-justify: inter-word;
}
</style>
@endpush