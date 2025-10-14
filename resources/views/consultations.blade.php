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
                                
                                <div class="form-group">
        <label for="service_type">Jenis Layanan yang Diinginkan</label>
        <select name="service_type" id="service_type" class="form-control">
            <option value="">Pilih Layanan</option>
            <option value="vaksinasi" {{ old('service_type') == 'vaksinasi' ? 'selected' : '' }}>Vaksinasi</option>
            <option value="rawat_inap" {{ old('service_type') == 'rawat_inap' ? 'selected' : '' }}>Rawat inap</option>
            <option value="operasi" {{ old('service_type') == 'operasi' ? 'selected' : '' }}>Operasi</option>
            <option value="hematology" {{ old('service_type') == 'hematology' ? 'selected' : '' }}>Hematology</option>
        </select>
    </div>
                                <br><div class="form-group">
        <label for="message">Pesan/Kebutuhan *</label>
        <textarea name="message" id="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
        @error('message') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <br><button type="submit" class="btn btn-purple">Kirim Konsultasi</button>
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
                    <p>drh Arundhina G, DV Pets Clinic,<br> Jl. Tj. Pura No.15, Karanganyar, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45212</p>
                </div>
                
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-phone text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Telepon</h5>
                    <p>+62 817-7002-9905</p>
                </div>
                
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-envelope text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Email</h5>
                    <p>dvpets@gmail.com<br>klinikhewan@gmail.com</p>
                </div>
            </div>
        </div>
    </section>
<!-- Tambahkan ini untuk menampilkan pesan sukses -->
@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@endsection