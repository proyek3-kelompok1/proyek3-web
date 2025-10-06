@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fw-bold text-purple mb-4">Hubungi Kami</h1>
                    <p class="lead">Kami siap membantu kebutuhan kesehatan hewan peliharaan Anda</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow border-0">
                        <div class="card-body p-5">
                            <h3 class="fw-bold text-purple mb-4">Form Kontak</h3>
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subjek</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-purple px-4">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-map-marker-alt text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Alamat</h5>
                    <p>Jl. Kesehatan Hewan No. 123<br>Jakarta, Indonesia</p>
                </div>
                
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-phone text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Telepon</h5>
                    <p>+62 123 4567 89<br>+62 987 6543 21</p>
                </div>
                
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-envelope text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Email</h5>
                    <p>info@klinikhewanungu.com<br>appointment@klinikhewanungu.com</p>
                </div>
            </div>
        </div>
    </section>
@endsection