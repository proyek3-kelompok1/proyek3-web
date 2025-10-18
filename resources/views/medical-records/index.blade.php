@extends('layouts.app')

@section('title', 'Rekam Medis Hewan - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-purple text-white">
                    <h4 class="mb-0"><i class="fas fa-file-medical me-2"></i>Cek Rekam Medis Hewan</h4>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        Masukkan kode booking dan email yang digunakan saat pemesanan untuk melihat rekam medis hewan kesayangan Anda.
                    </p>

                    <form action="{{ route('medical-records.search') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="kode_booking" class="form-label fw-bold text-purple">Kode Booking</label>
                            <input type="text" class="form-control" id="kode_booking" name="kode_booking" 
                                   value="{{ old('kode_booking') }}" required 
                                   placeholder="Contoh: VKS20231215001">
                            <div class="form-text">Kode booking dapat ditemukan di email konfirmasi atau tiket pemesanan</div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="form-label fw-bold text-purple">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email') }}" required 
                                   placeholder="Email yang digunakan saat pemesanan">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-purple">
                                <i class="fas fa-search me-2"></i>Cari Rekam Medis
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-purple"><i class="fas fa-info-circle me-2"></i>Informasi</h6>
                        <p class="small mb-0">
                            Rekam medis berisi riwayat pemeriksaan, diagnosa, resep obat, dan vaksinasi hewan peliharaan Anda.
                            Data akan tampil setelah proses pemeriksaan selesai dilakukan oleh dokter.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-purple {
    background-color: #6f42c1;
}
.text-purple {
    color: #6f42c1;
}
.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: white;
}
</style>
@endsection