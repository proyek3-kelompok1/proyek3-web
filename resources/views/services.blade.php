@extends('layouts.app')

@section('title', 'Layanan')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fw-bold text-purple mb-4">Layanan Kami</h1>
                    <p class="lead">Berbagai layanan kesehatan hewan yang kami sediakan untuk kebutuhan hewan peliharaan Anda</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-stethoscope text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Konsultasi Umum</h5>
                            <p class="card-text">Pemeriksaan kesehatan rutin, diagnosis penyakit, dan konsultasi kesehatan untuk hewan peliharaan Anda.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-syringe text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Vaksinasi</h5>
                            <p class="card-text">Program vaksinasi lengkap untuk melindungi hewan dari berbagai penyakit menular.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-tooth text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Perawatan Gigi</h5>
                            <p class="card-text">Pembersihan karang gigi, pencabutan gigi, dan perawatan kesehatan mulut lainnya.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-cut text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Operasi</h5>
                            <p class="card-text">Tindakan operasi baik elektif maupun darurat dengan standar keamanan tinggi.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-microscope text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Laboratorium</h5>
                            <p class="card-text">Pemeriksaan darah, urin, feses, dan tes diagnostik lainnya untuk mendukung diagnosis.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-home text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Rawat Inap</h5>
                            <p class="card-text">Fasilitas rawat inap yang nyaman untuk hewan yang membutuhkan perawatan intensif.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection