@extends('layouts.app')

@section('title', 'Janji Temu Berhasil - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow text-center">
                <div class="card-body p-5">
                    <div class="text-success mb-4">
                        <i class="fas fa-check-circle fa-5x"></i>
                    </div>
                    
                    <h2 class="text-purple mb-3">Janji Temu Berhasil Dibuat!</h2>
                    
                    <p class="lead mb-4">
                        Terima kasih telah membuat janji temu di DV Pets Clinic. Kami akan mengkonfirmasi janji temu Anda melalui email atau telepon.
                    </p>
                    
                    <div class="alert alert-info text-start">
                        <h6 class="alert-heading">Informasi Penting:</h6>
                        <ul class="mb-0">
                            <li>Datang 15 menit sebelum jadwal janji temu</li>
                            <li>Bawa catatan medis hewan jika ada</li>
                            <li>Pastikan hewan dalam kondisi tenang</li>
                        </ul>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <a href="{{ url('/') }}" class="btn btn-purple me-md-2">Kembali ke Beranda</a>
                        <a href="{{ route('appointments.create') }}" class="btn btn-outline-purple">Buat Janji Lain</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-purple {
    color: #6f42c1;
}
.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: white;
}
.btn-outline-purple {
    border-color: #6f42c1;
    color: #6f42c1;
}
.btn-outline-purple:hover {
    background-color: #6f42c1;
    color: white;
}
</style>
@endsection