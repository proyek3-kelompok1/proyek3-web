@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fw-bold text-purple mb-4">Tentang Klinik DV Pets</h1>
                    <p class="lead">Kami berkomitmen memberikan perawatan kesehatan terbaik untuk hewan peliharaan Anda</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold text-purple mb-4">Visi & Misi Kami</h2>
                    <p class="mb-4">Klinik Hewan DV Pets didirikan dengan visi untuk menjadi penyedia layanan kesehatan hewan terdepan yang memberikan perawatan komprehensif dengan standar tertinggi.</p>
                    
                    <h5 class="fw-bold text-purple">Visi</h5>
                    <p class="mb-4">Menjadi klinik hewan terpercaya yang memberikan kontribusi positif bagi kesehatan dan kesejahteraan hewan peliharaan di Indonesia.</p>
                    
                    <h5 class="fw-bold text-purple">Misi</h5>
                    <ul>
                        <li class="mb-2">Menyediakan layanan kesehatan hewan yang berkualitas tinggi</li>
                        <li class="mb-2">Mengedukasi pemilik hewan tentang perawatan yang tepat</li>
                        <li class="mb-2">Menggunakan teknologi dan metode terkini dalam perawatan</li>
                        <li class="mb-2">Memberikan pelayanan dengan penuh kasih sayang dan empati</li>
                    </ul>
                </div>
                
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1579202673506-ca3ce28943ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                         alt="Tentang Kami" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>
@endsection